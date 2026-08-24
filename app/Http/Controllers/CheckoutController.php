<?php

namespace App\Http\Controllers;

use App\Enums\CheckoutIntent;
use App\Events\GenerateQuote;
use App\Events\OrderPlaced;
use App\Helpers\FunHelper;
use App\Services\CheckoutIntentService;
use App\Services\QuoteConvertService;
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
use App\Models\EmergencyModeSetting;
use App\Support\LookupDateRange;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CheckoutIntentService $intents,
        private readonly QuoteConvertService $quoteConvert,
    ) {
    }

    /**
     * Step 1 of the flow: shipping details, payment terms and billing details on
     * a single screen for both the order and the quote path.
     */
    public function index(Request $request)
    {
        if (EmergencyModeSetting::current()->is_enabled) {
            return redirect()->route('cart')->with('error', emergencyModeMessage());
        }

        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();

        return view('shipping', array_merge([
            'cart' => $cart,
            'user' => $user,
            'userDetail' => $user_detail,
            'canSaveAsQuote' => $this->intents->allows(CheckoutIntent::Quote),
        ], $this->paymentContext($customer_id)));
    }

    /**
     * The payment step now lives on the combined first screen. Kept as a redirect
     * so bookmarks, browser history and existing redirects keep working.
     */
    public function payment(Request $request)
    {
        return redirect()->route('shipping');
    }

    /**
     * Payment terms and, for credit-card accounts on the order path, the cards on
     * file. Shared by the combined first screen.
     */
    protected function paymentContext($customer_id): array
    {
        $apiUrl = 'GetCustomerDetails/' . $customer_id;
        $apiCustomerDetails = null;
        $apiError = null;
        $creditCardDetails = [];
        $paymentTermCode = null;
        $isCreditCardCustomer = false;
        $shouldShowCreditCards = false;

        // A quote never captures payment, so the card selector belongs to the
        // order path only. Without this a credit-card dealer saving a quote would
        // hit a dead end on this step when they have no card on file.
        $checkoutIntent = $this->intents->current();
        $isOrderPath = $checkoutIntent === null || $checkoutIntent->isOrder();

        try {
            // SysproService::getCustomerDetails returns an array, not a response object
            $customerDetails = SysproService::getCustomerDetails($apiUrl);

            if (!empty($customerDetails)) {
                $apiCustomerDetails = $customerDetails;
                $paymentTermCode = data_get($customerDetails, 'PaymentTermCode') ?? data_get($customerDetails, 'Customer.PaymentTermCode');
                $isCreditCardCustomer = $paymentTermCode === 'CC';
                $shouldShowCreditCards = $isCreditCardCustomer && $isOrderPath;

                if ($shouldShowCreditCards) {
                    // Extract CreditCardDetails from the customer details array
                    // The structure returned by getCustomerDetails is the Customer object directly
                    if (isset($customerDetails['CreditCardDetails'])) {
                        $creditCardDetails = $customerDetails['CreditCardDetails'];
                    } elseif (isset($customerDetails['Customer']['CreditCardDetails'])) {
                        $creditCardDetails = $customerDetails['Customer']['CreditCardDetails'];
                    }
                } else {
                    if (!$isCreditCardCustomer) {
                        $this->clearSelectedCardSession();
                        Log::info('Payment - Customer payment term is not CC; skipping credit card details.', [
                            'customer_id' => $customer_id,
                            'payment_term_code' => $paymentTermCode,
                        ]);
                    }
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

        // Remembered so switching the choice mid-flow can tell whether a card is
        // still owed without calling Syspro again.
        if ($paymentTermCode !== null) {
            session(['checkout_payment_term_code' => $paymentTermCode]);
        }

        return [
            'apiCustomerDetails' => $apiCustomerDetails,
            'apiError' => $apiError,
            'creditCardDetails' => $creditCardDetails,
            'paymentTermCode' => $paymentTermCode,
            'shouldShowCreditCards' => $shouldShowCreditCards,
        ];
    }

    /**
     * checkout page cart details.
     */
    public function checkout(Request $request)
    {
        if (EmergencyModeSetting::current()->is_enabled) {
            return redirect()->route('cart')->with('error', emergencyModeMessage());
        }

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
                'canSaveAsQuote' => $this->intents->allows(CheckoutIntent::Quote),
                'convertingQuoteNo' => $this->quoteConvert->purchaseOrderNo(),
            ));
        }
        return redirect()->route('cart');
    }

    /**
     * quote page cart details.
     */
    public function quote(Request $request)
    {
        if (EmergencyModeSetting::current()->is_enabled) {
            return redirect()->route('cart')->with('error', emergencyModeMessage());
        }

        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        return view('quote', array(
            'cart' => $cart,
            'user' => $user,
            'user_detail' => $user_detail,
            'selectedCard' => $this->getSelectedCardFromSession(),
            'canPlaceOrder' => $this->intents->allows(CheckoutIntent::Order),
        ));
    }

    /**
     * Order variant of the completion screen. Reached after Place Order, and
     * revisitable afterwards so a refresh does not replay the submit.
     */
    public function complete(Order $order)
    {
        if ((string) $order->customer_number !== (string) getCustomerId()) {
            abort(403);
        }

        $order->load([
            'OrderItem' => function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('action')
                        ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                });
            },
            'OrderItem.Product.Media',
        ]);

        $apiResponse = null;
        if ($order->purchase_order_no) {
            try {
                $apiResponse = SysproService::getOrderDetails('GetOrderDetails/' . $order->purchase_order_no);
            } catch (\Exception $e) {
                Log::error('Failed to fetch order details for completion page: ' . $e->getMessage(), [
                    'order_id' => $order->id,
                    'purchase_order_no' => $order->purchase_order_no,
                ]);
            }
        }

        return view('order-thank-you', [
            'order' => $order,
            'processedItems' => $this->processOrderLinesWithComments($order, $apiResponse),
        ]);
    }

    /**
     * Save Order in DB
     */
    public function saveOrder(Request $request)
    {
        if (EmergencyModeSetting::current()->is_enabled) {
            return redirect()->back()->with('error', emergencyModeMessage());
        }

        $customer = getCustomer();
        if (!$customer->hasPermissionTo('placeOrders')) {
            abort(403);
        }

        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $cart = $request->filled('cart_id')
            ? Cart::where('id', $request->cart_id)->where('user_id', $user->id)->first()
            : $this->intents->activeCart();

        // Placing an order deletes the cart. A refresh, a second click, or the
        // browser replaying the POST then finds nothing left — that is success,
        // not a missing choice.
        if ($cart === null || !$cart->hasItems()) {
            return $this->redirectIfOrderAlreadyPlaced();
        }

        // Submitting this form is itself the "place order" decision, matching
        // quote save. A lost column value must not bounce a dealer off the
        // review they already reached.
        $intent = $this->intents->current($cart);
        if ($intent === null) {
            $this->intents->remember($cart, CheckoutIntent::Order);
            $intent = CheckoutIntent::Order;
        }
        if ($intent->isQuote()) {
            return redirect()->route('quote');
        }

        $request->validate([
            'customer_po_number' => ['required']
        ], [
            'customer_po_number.required' => 'The PO number is required.',
        ]);
        $total = 0;
        $isDuplicate = 'N';
        if ($request->has('agree_duplicate')) {
            $isDuplicate = 'Y';
        }

        $cart->update(['purchase_order_no' => $request->customer_po_number]);

        if ($this->quoteConvert->isConverting()) {
            return $this->completeQuoteConversion($request, $user, $cart, $isDuplicate);
        }

        DB::beginTransaction();
        try {
            $customer_id = getCustomerId();
            $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            $order = Order::create([
                'user_id' => $cart->user_id,
                'purchase_order_no' => null,
                'customer_po_number' => $request->customer_po_number ?? null,
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
            $pdfContent = null;
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
            // Only pass valid PDF content for email attachment.
            if (!empty($pdfContent)) {
                $isPdf = str_starts_with($pdfContent, '%PDF-');
                if (!$isPdf || strlen($pdfContent) < 1024) {
                    Log::warning('[PDF] Invalid PDF content for email, falling back to file attachment path', [
                        'order_id' => $order->id,
                        'bytes' => strlen($pdfContent),
                        'is_pdf_header' => $isPdf,
                    ]);
                    $pdfContent = null;
                }
            }
            OrderPlaced::dispatch($order, $pdfContent);
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();

            DB::commit();

            $completionUrl = route('order.complete', $order->id);
            $this->intents->rememberCompleted($completionUrl);

            return redirect()->to($completionUrl);
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
            ->where('customer_number', $customer_number)
            ->where('status', '!=', 'D')
            ->where('status', '!=', 'F');

        $startDate = LookupDateRange::parseStart($request->start_date);
        if ($startDate !== null) {
            $query->where('created_at', '>=', $startDate);
        }

        $endDate = LookupDateRange::parseEnd($request->end_date);
        if ($endDate !== null) {
            $query->where('created_at', '<=', $endDate);
        }

        if (!empty($request->search_input)) {
            $search = $request->search_input;
            $query->where(function ($q) use ($search) {
                $q->where('purchase_order_no', 'like', "%{$search}%")
                    ->orWhere('bp_number', 'like', "%{$search}%")
                    ->orWhere('customer_po_number', 'like', "%{$search}%");
            });
        }

        $order = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('order', [
            'order' => $order,
            'start_date' => $request->start_date ?? '',
            'end_date' => $request->end_date ?? '',
            'search' => $request->search_input ?? '',
        ]);
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

        if (!$order || (string) $order->customer_number !== (string) getCustomerId()) {
            abort(403);
        }

        $customer_id = getCustomerId();
        $this->ensureCustomerDetailsInSessionForPdf($customer_id);

        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first()
            ?? $user->getUserDetails;
        
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

    private function ensureCustomerDetailsInSessionForPdf(string $customerId): void
    {
        if (session()->has('customer_details') && session()->has('customer_address')) {
            return;
        }

        try {
            $customerDetails = SysproService::getCustomerDetails('GetCustomerDetails/' . $customerId);
            if (!empty($customerDetails)) {
                session()->put('customer_details', $customerDetails);

                if (!session()->has('customer_address') && !empty($customerDetails['ShipToAddresses'][0])) {
                    session()->put('customer_address', $customerDetails['ShipToAddresses'][0]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch customer details for receipt PDF: ' . $e->getMessage());
        }
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

    /**
     * Finish converting a saved quote through the order review screen using the
     * same Syspro document number, then land on the order completion page.
     */
    private function completeQuoteConversion(Request $request, $user, Cart $cart, string $isDuplicate)
    {
        $quoteNumber = $this->quoteConvert->purchaseOrderNo();
        $customerId = getCustomerId();

        $order = Order::where('purchase_order_no', $quoteNumber)
            ->where('customer_number', $customerId)
            ->first();

        if ($order === null) {
            return redirect()->route('quotes')->with('error', 'Quote not found.');
        }

        if ($blocked = $this->quoteConvert->blockedReason($order)) {
            $this->quoteConvert->forget();

            return redirect()->route('quotes')->with('error', $blocked);
        }

        DB::beginTransaction();

        try {
            $orderDetails = SysproService::getOrderDetails('GetOrderDetails/' . $quoteNumber);
            if (empty($orderDetails['response']) || !empty($orderDetails['response']['Error'])) {
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'Order details are not available in the system. Please contact support.');
            }

            $response = SysproService::placeOrder('PlaceOrder', $quoteNumber, $request->customer_po_number, $isDuplicate);

            $errorMessage = null;
            if (!empty($response['response']['Error'])) {
                $errorMessage = $response['response']['Message'] ?? $response['response']['Error'];
            } elseif (!empty($response['response']['Message']) &&
                (stripos($response['response']['Message'], 'not permitted') !== false ||
                 stripos($response['response']['Message'], 'error') !== false ||
                 stripos($response['response']['Message'], 'failed') !== false)) {
                $errorMessage = $response['response']['Message'];
            } elseif (!empty($response['code']) && $response['code'] >= 400) {
                $errorMessage = $response['response']['Message'] ?? 'API request failed';
            }

            if ($errorMessage) {
                DB::rollBack();

                if (stripos($errorMessage, 'Change not permitted') !== false) {
                    $errorMessage = 'This quote cannot be converted to an order. It may have already been placed or is in a state that prevents changes. Please contact support if you believe this is an error.';
                }

                return redirect()->back()->withInput()->with('error', $errorMessage);
            }

            if (empty($response['response']['OrderNumber'])) {
                DB::rollBack();

                return redirect()->back()->withInput()->with('error', 'Unable to convert this quote to an order. Please try again.');
            }

            $details = SysproService::getOrderDetails('GetOrderDetails/' . $quoteNumber);
            $order->update([
                'status' => $details['response']['Status'] ?? $order->status,
                'customer_po_number' => $details['response']['CustomerPONumber'] ?? $request->customer_po_number,
                'converted_from_quote_no' => $quoteNumber,
            ]);

            OrderPlaced::dispatch($order);

            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
            $this->quoteConvert->forget();

            DB::commit();

            $completionUrl = route('order.complete', $order->id);
            $this->intents->rememberCompleted($completionUrl);

            return redirect()->to($completionUrl);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote conversion failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'An error occurred while converting your quote. Please try again.');
        }
    }

    /**
     * After a successful place, the cart is gone. Replays of Place Order must
     * land on what was created, not on a "choose again" error.
     */
    private function redirectIfOrderAlreadyPlaced()
    {
        $completed = $this->intents->completedUrl();

        if ($completed !== null) {
            return redirect()->to($completed);
        }

        return redirect()->route('order');
    }
}
