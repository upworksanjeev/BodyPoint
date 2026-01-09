<?php

namespace App\Http\Controllers;

use App\Events\GenerateQuote;
use App\Events\OrderPlaced;
use App\Helpers\FunHelper;
use App\Services\SysproService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Cart;
use App\Models\UserDetails;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\CartAttribute;
use App\Models\OrderAttribute;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     *  Shipping details.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        return view('shipping', array(
            'cart' => $cart,
            'user' => $user,
            'userDetail' => $user_detail,
        ));
    }

    /**
     * Payment select page.
     */
    public function payment(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();

        // Fetch customer details from the specified API endpoint
        $customer_id = getCustomerId(); 
        $apiUrl = 'GetCustomerDetails/' . $customer_id;
        $apiCustomerDetails = null;
        $apiError = null;
        $creditCardDetails = [];
        $paymentTermCode = null;
        $shouldShowCreditCards = false;
        
        try {
            // SysproService::getCustomerDetails returns an array, not a response object
            $customerDetails = SysproService::getCustomerDetails($apiUrl);
            
            if (!empty($customerDetails)) {
                $apiCustomerDetails = $customerDetails;
                $paymentTermCode = data_get($customerDetails, 'PaymentTermCode') ?? data_get($customerDetails, 'Customer.PaymentTermCode');
                $shouldShowCreditCards = $paymentTermCode === 'CC';

                if ($shouldShowCreditCards) {
                    // Extract CreditCardDetails from the customer details array
                    // The structure returned by getCustomerDetails is the Customer object directly
                    if (isset($customerDetails['CreditCardDetails'])) {
                        $creditCardDetails = $customerDetails['CreditCardDetails'];
                    } elseif (isset($customerDetails['Customer']['CreditCardDetails'])) {
                        $creditCardDetails = $customerDetails['Customer']['CreditCardDetails'];
                    }
                } else {
                    $this->clearSelectedCardSession();
                    Log::info('Payment - Customer payment term is not CC; skipping credit card details.', [
                        'customer_id' => $customer_id,
                        'payment_term_code' => $paymentTermCode,
                    ]);
                    $creditCardDetails = [];
                }
            } else {
                $apiError = 'No customer details found or API request failed.';
            }
        } catch (\Exception $e) {
            $apiError = 'Error fetching customer details: ' . $e->getMessage();
            Log::error('Payment - Error fetching customer details:', [
                'error' => $e->getMessage(),
                'customer_id' => $customer_id,
                'apiUrl' => $apiUrl,
            ]);
        }
        return view('payment', array(
            'cart' => $cart,
            'apiCustomerDetails' => $apiCustomerDetails,
            'apiError' => $apiError,
            'creditCardDetails' => $creditCardDetails,
            'paymentTermCode' => $paymentTermCode,
            'shouldShowCreditCards' => $shouldShowCreditCards,
        ));
    }

    /**
     * checkout page cart details.
     */
    public function checkout(Request $request)
    {
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        if (isset($cart[0])) {
            $customer_id = getCustomerId();
            $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            $string = uniqid(rand());
            $purchase_order_no = $cart[0]['purchase_order_no'] ? $cart[0]['purchase_order_no'] : substr($string, 0, 10);
            return view('checkout', array(
                'cart' => $cart,
                'user' => $user,
                'user_detail' => $user_detail,
                'purchase_order_no' => $purchase_order_no,
                'selectedCard' => $this->getSelectedCardFromSession(),
            ));
        }
        return redirect()->route('cart');
    }

    /**
     * quote page cart details.
     */
    public function quote(Request $request)
    {
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        return view('quote', array(
            'cart' => $cart,
            'user' => $user,
            'user_detail' => $user_detail,
            'selectedCard' => $this->getSelectedCardFromSession(),
        ));
    }

    /**
     * Save Order in DB
     */
    public function saveOrder(Request $request)
    {


        $customer = getCustomer();
        if (!$customer->hasPermissionTo('placeOrders')) {
            abort(403);
        }
        $request->validate([
            'customer_po_number' => ['required']
        ], [
            'customer_po_number.required' => 'The PO number is required.',
        ]);
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $total = 0;
        $isDuplicate = 'N';
        if ($request->has('agree_duplicate')) {
            $isDuplicate = 'Y';
        }
        if (!$request->has('cart_id')) {
            return redirect()->route('cart')->with('error', 'Cart ID is missing.');
        }

        $cart = Cart::where('id', $request->cart_id)->first();

        if ($cart) {
            $cart->update(['purchase_order_no' => $request->customer_po_number]);
        } else {
            return redirect()->route('cart')->with('error', 'Cart not found.');
        }

        DB::beginTransaction();
        try {
            $customer_id = getCustomerId();
            $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            $order = Order::create([
                'user_id' => $cart->user_id,
                'purchase_order_no' => $request->purchase_order_no ?? $cart->purchase_order_no,
                'total_items' => $cart->total_items,
                'associate_customer_id' => $customer->id ?? null,
                'customer_number' => $customer_id,
            ]);

            // Extract credit card data from request
            $cardData = null;
            if ($request->has('selected_credit_card') && !empty($request->selected_credit_card)) {
                try {
                    $cardData = json_decode($request->selected_credit_card, true);
                    
                    // Log credit card data received
                    Log::info('Order - Credit Card Data Received:', [
                        'selected_credit_card' => $request->selected_credit_card,
                        'credit_card_last_four' => $request->credit_card_last_four,
                        'credit_card_expiry' => $request->credit_card_expiry,
                        'credit_card_type' => $request->credit_card_type,
                        'credit_card_holder_name' => $request->credit_card_holder_name,
                        'parsed_card_data' => $cardData,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Order - Failed to parse credit card data: ' . $e->getMessage());
                }
            } else {
                Log::info('Order - No credit card data provided in request');
            }

            Log::info('Order Created:', [
                'order_id' => $order->id,
                'user_id' => $user->id,
                'purchase_order_no' => $request->purchase_order_no,
                'total_items' => $cart->total_items,
                'associate_customer_id' => $customer->id ?? null,
                'customer_number' => $customer_id,
                'has_credit_card' => !empty($cardData),
            ]);
            $cartitems = CartItem::where('cart_id', $cart->id)->get();
            foreach ($cartitems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'variation_id' => $cartItem->variation_id,
                    'marked_for' => $cartItem->marked_for,
                    'msrp' => $cartItem->msrp,
                    'sku' => $cartItem->sku,
                    'price' => $cartItem->price,
                    'discount' => $cartItem->discount,
                    'discount_price' => $cartItem->discount_price,
                    'quantity' => $cartItem->quantity,
                ]);
                $total += $cartItem->discount_price * $cartItem->quantity;
            }
            $url = 'CreateQuote';
            $order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, $request->customer_po_number, 'Y', $isDuplicate, $cardData);

            if (!empty($order_syspro['response']['OrderNumber'])) {
                $order->update([
                    'purchase_order_no' => $order_syspro['response']['OrderNumber'],
                    'customer_po_number' => $request->customer_po_number ?? null
                ]);
                $url = 'GetOrderDetails/' . $order->purchase_order_no;
                $response = SysproService::getOrderDetails($url);
                $order->update([
                    'status' => $response['response']['Status'],
                    'total' =>  $total
                ]);
            } elseif (!empty($order_syspro['response']['Error'])) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', $order_syspro['response']['Message']);
            }
            $customer_id = getCustomerId();
            $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            /*$pdf = Pdf::loadView('order-receipt', ['order' => $order, 'user' => $user, 'userDetail' => $user_detail]);
            $pdfContent = $pdf->output();
            FunHelper::saveOrderPlacedPdf($pdfContent, $order);*/

            // Process order lines with comments from API response
            $processedItems = $this->processOrderLinesWithComments($order, $response ?? null);
            
            $pdfPath = null;
            try {
                $pdf = Pdf::loadView('order-receipt', [
                    'order'      => $order,
                    'user'       => $user,
                    'userDetail' => $user_detail,
                    'processedItems' => $processedItems,
                ]);
                $pdfContent = $pdf->output();

                // If your helper returns a path, capture it; if not, save manually:
                try {
                    // preferred if your helper handles storage
                    FunHelper::saveOrderPlacedPdf($pdfContent, $order);
                    Log::info('[PDF] Saved via helper', ['order_id' => $order->id]);
                } catch (\Throwable $e) {
                    // manual fallback to storage/app/orders/{id}.pdf
                    $pdfPath = storage_path('app/orders/'.$order->id.'.pdf');
                    if (!is_dir(dirname($pdfPath))) {
                        @mkdir(dirname($pdfPath), 0775, true);
                    }
                    file_put_contents($pdfPath, $pdfContent);
                    Log::info('[PDF] Saved manually', ['order_id' => $order->id, 'path' => $pdfPath]);
                }
            } catch (\Throwable $e) {
                Log::error('[PDF] Generation failed', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
                
            }
            OrderPlaced::dispatch($order);
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
            DB::commit();
            
            // Process order lines with comments for thank you page
            $processedItems = $this->processOrderLinesWithComments($order, $response ?? null);
            
            return view('order-thank-you', [
                'order' => $order,
                'processedItems' => $processedItems
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while placing your order. Please try again.');
        }
    }

    /**
     * get all Orders
     */
    public function myOrder(Request $request)
    {
        $customer = getCustomer();
        if (!$customer->hasPermissionTo('orderHistory')) {
            //abort(403);
            return redirect()->route('dashboard');
        }
        $user = Auth::user();
        $customer_number = session('customer_id') ?? auth()->user()->default_customer_id;
        if ($request->start_date != '') {
            $start_date = date('y-m-d 00:00:01', strtotime($request->start_date));
        }
        if ($request->end_date != '') {
            $end_date = date('y-m-d 23:59:59', strtotime($request->end_date));
        }
        // if ($request->search_input != '' && $request->start_date != '' && $request->end_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->orWhere('customer_po_number', 'like', "%" . $request->search_input . "%")->orderBy('created_at','desc')->get();
        // } elseif ($request->search_input != '' && $request->start_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '>=', $start_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->orWhere('customer_po_number', 'like', "%" . $request->search_input . "%")->get();
        // } elseif ($request->start_date != '' && $request->end_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->orWhereNull('status')->orderBy('created_at','desc')->get();
        // } elseif ($request->search_input != '' && $request->end_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '<=', $end_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->orWhere('customer_po_number', 'like', "%" . $request->search_input . "%")->orderBy('created_at','desc')->get();
        // } elseif ($request->search_input != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->orWhere('customer_po_number', 'like', "%" . $request->search_input . "%")->orderBy('created_at','desc')->get();
        // } elseif ($request->start_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '>=', $start_date)->orderBy('created_at','desc')->get();
        // } elseif ($request->end_date != '') {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->where('created_at', '<=', $end_date)->orderBy('created_at','desc')->get();
        // } else {
        //     $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->orderBy('created_at','desc')->get();
        // }

        $query = Order::with('User', 'OrderItem.Product.Media')
            //->where('user_id', $user->id)
            ->where('customer_number', $customer_number)
            ->where('status', '!=', 'D')
            ->where('status', '!=', 'F');

        // Apply start date filter
        if (!empty($request->start_date)) {
            $start_date = date('Y-m-d 00:00:00', strtotime($request->start_date));
            $query->where('created_at', '>=', $start_date);
        }

        // Apply end date filter
        if (!empty($request->end_date)) {
            $end_date = date('Y-m-d 23:59:59', strtotime($request->end_date));
            $query->where('created_at', '<=', $end_date);
        }

        // Apply search input filter
        if (!empty($request->search_input)) {
            $search = $request->search_input;
            $query->where(function ($q) use ($search) {
                $q->where('purchase_order_no', 'like', "%$search%")
                    ->orWhere('bp_number', 'like', "%$search%")
                    ->orWhere('customer_po_number', 'like', "%$search%");
            });
        }

        // If both start and end date are set but no status, check for null status optionally
        if (!empty($request->start_date) && !empty($request->end_date) && empty($request->search_input)) {
            $query->orWhereNull('status');
        }
        $order = $query->orderBy('created_at', 'desc')->get();
        $order = $query->orderBy('created_at', 'desc')->paginate(10);
        $user_detail = UserDetails::where('user_id', $user->id)->first();
        if ($request->has('download')) {
            // Process each order with comments
            $ordersWithComments = [];
            foreach ($order as $ord) {
                $ord = Order::with('User', 'OrderItem.Product.Media')->where('id', $ord->id)->first();
                $apiResponse = null;
                if ($ord->purchase_order_no) {
                    try {
                        $url = 'GetOrderDetails/' . $ord->purchase_order_no;
                        $apiResponse = SysproService::getOrderDetails($url);
                    } catch (\Exception $e) {
                        Log::error('Failed to fetch order details for all-order-receipt: ' . $e->getMessage());
                    }
                }
                $processedItems = $this->processOrderLinesWithComments($ord, $apiResponse);
                $ordersWithComments[] = [
                    'order' => $ord,
                    'processedItems' => $processedItems
                ];
            }
            $pdf = Pdf::loadView('all-order-receipt', [
                'orders' => $order, 
                'user' => $user, 
                'userDetail' => $user_detail,
                'ordersWithComments' => $ordersWithComments
            ]);
            return $pdf->download();
        } else {
            return view('order', array(
                'order' => $order,
                'start_date' => $request->start_date ?? '',
                'end_date' => $request->end_date ?? '',
                'search' => $request->search_input ?? '',
            ));
        }
    }

    /**
     *  PDF download for save quote
     */
    public function pdfDownload(Request $request)
    {
        set_time_limit(3600);
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $price_option = "all_price";
        if ($request->has('price_option')) {
            $price_option = $request->price_option;
        }
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', operator: $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        $pdf = Pdf::loadView('pdf', ['cart' => $cart, 'user' => $user, 'userDetail' => $user_detail, 'priceOption' => $price_option]);
        $pdf->render();
        $pdfContent = $pdf->output();
        FunHelper::saveGenerateQuotePdf($pdfContent, $user);
        GenerateQuote::dispatch($cart, $user, $user_detail, $price_option, true);
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(34, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));
        return $pdf->download();
    }

    /**
     * Process order lines from API response to combine products with comments
     */
    private function processOrderLinesWithComments($order, $apiResponse = null)
    {
        $orderItems = $order->OrderItem;
        $processedItems = [];
        
        // If API response is provided, use it to get comments
        if ($apiResponse && isset($apiResponse['response']['Line'])) {
            $lines = $apiResponse['response']['Line'];
            
            // Create a map of comments by SKU from API response
            // Process lines sequentially - product followed by its comment
            $commentsBySku = [];
            $i = 0;
            while ($i < count($lines)) {
                $line = $lines[$i];
                $lineType = isset($line['LineType']) ? (string)$line['LineType'] : '';
                
                // If it's a product line (LineType = "1")
                if ($lineType === '1' && !empty($line['StockCode'])) {
                    $sku = $line['StockCode'];
                    
                    // Check if next line is a comment for this product
                    if ($i + 1 < count($lines)) {
                        $nextLine = $lines[$i + 1];
                        $nextLineType = isset($nextLine['LineType']) ? (string)$nextLine['LineType'] : '';
                        
                        if ($nextLineType === '6' && !empty($nextLine['CommentLine'])) {
                            $commentsBySku[$sku] = $nextLine['CommentLine'];
                            $i++; // Skip the comment line as we've processed it
                        }
                    }
                }
                
                $i++;
            }
            
            // Now process order items and attach comments
            foreach ($orderItems as $item) {
                $processedItems[] = [
                    'orderItem' => $item,
                    'comment' => $commentsBySku[$item->sku] ?? null
                ];
            }
        } else {
            // Fallback: if no API response, just use order items without comments
            foreach ($orderItems as $item) {
                $processedItems[] = [
                    'orderItem' => $item,
                    'comment' => null
                ];
            }
        }
        
        return $processedItems;
    }

    /**
     *  receipt download for orders
     */
    public function receiptDownload(Request $request)
    {
        set_time_limit(3600);
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $order = Order::with('User', 'OrderItem.Product.Media')->where('id', $request->order_id)->first();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        
        // Fetch API response to get comments
        $apiResponse = null;
        if ($order->purchase_order_no) {
            try {
                $url = 'GetOrderDetails/' . $order->purchase_order_no;
                $apiResponse = SysproService::getOrderDetails($url);
            } catch (\Exception $e) {
                Log::error('Failed to fetch order details for receipt: ' . $e->getMessage());
            }
        }
        
        $processedItems = $this->processOrderLinesWithComments($order, $apiResponse);
        
        $pdf = Pdf::loadView('order-receipt', [
            'order' => $order, 
            'user' => $user, 
            'userDetail' => $user_detail,
            'processedItems' => $processedItems
        ]);
        return $pdf->download();
    }

    /**
     * Update Purchase No in cart table
     **/
    public function updatePurchaseNo(Request $request)
    {
        if ($request->has('cart_id')) {
            Cart::where('id', $request->cart_id)->update(['purchase_order_no' => $request->purchase_order_no]);
        }
    }

    public function storeSelectedCard(Request $request)
    {
        $cardJson = $request->input('selected_credit_card');

        if ($cardJson) {
            $cardData = null;
            try {
                $cardData = json_decode($cardJson, true);
            } catch (\Throwable $e) {
                Log::warning('Payment - Failed to decode selected credit card JSON', [
                    'error' => $e->getMessage(),
                    'selected_credit_card' => $cardJson,
                ]);
            }

            session([
                'selected_credit_card' => $cardJson,
                'selected_credit_card_last_four' => $request->input('credit_card_last_four'),
                'selected_credit_card_expiry' => $request->input('credit_card_expiry'),
                'selected_credit_card_type' => $request->input('credit_card_type'),
                'selected_credit_card_holder_name' => $request->input('credit_card_holder_name'),
                'selected_credit_card_decoded' => $cardData,
            ]);
        } else {
            $this->clearSelectedCardSession();
        }

        return redirect()->route('checkout');
    }

    protected function getSelectedCardFromSession(): array
    {
        return [
            'json' => session('selected_credit_card'),
            'last_four' => session('selected_credit_card_last_four'),
            'expiry' => session('selected_credit_card_expiry'),
            'type' => session('selected_credit_card_type'),
            'holder_name' => session('selected_credit_card_holder_name'),
            'decoded' => session('selected_credit_card_decoded'),
        ];
    }

    protected function clearSelectedCardSession(): void
    {
        session()->forget([
            'selected_credit_card',
            'selected_credit_card_last_four',
            'selected_credit_card_expiry',
            'selected_credit_card_type',
            'selected_credit_card_holder_name',
            'selected_credit_card_decoded',
        ]);
    }
}
