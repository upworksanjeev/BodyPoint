<?php

namespace App\Http\Controllers\Quote;

use App\Events\GenerateQuote;
use App\Helpers\FunHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderAttribute;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserDetails;
use App\Services\SysproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class QuoteController extends Controller
{
    public function index(Request $request)
    {

        $customer = getCustomer();
        if (!$customer->hasPermissionTo('getQuotes')) {
            return redirect()->route('dashboard');
        }

        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $customer_number = session()->get('customer_id') ?? auth()->user()->default_customer_id;
        if ($request->start_date != '') {
            $start_date = date('y-m-d 00:00:01', strtotime($request->start_date));
        }
        if ($request->end_date != '') {
            $end_date = date('y-m-d 23:59:59', strtotime($request->end_date));
        }
        if ($request->search_input != '' && $request->start_date != '' && $request->end_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                //->get();
                ->paginate(10);
        } elseif ($request->search_input != '' && $request->start_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                //->get();
                ->paginate(10);
        } elseif ($request->start_date != '' && $request->end_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        } elseif ($request->search_input != '' && $request->end_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        } elseif ($request->search_input != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        } elseif ($request->start_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        } elseif ($request->end_date != '') {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '<=', $end_date)
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        } else {
            $quotes = Order::with([
                'User',
                'OrderItem' => function ($query) {
                    $query->where(function ($q) {
                        $q->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    });
                },
                'OrderItem.Product.Media'
            ])
                //->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                //->get();
                ->paginate(10);
        }
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();

        // Build comment lines for each quote from Syspro API response
        $quotesWithComments = [];
        $quotesComments = [];
        foreach ($quotes as $quote) {
            $apiResponse = null;
            if ($quote->purchase_order_no) {
                try {
                    $url = 'GetOrderDetails/' . $quote->purchase_order_no;
                    $apiResponse = SysproService::getOrderDetails($url);
                } catch (\Exception $e) {
                    Log::error('Failed to fetch order details for quote comments: ' . $e->getMessage(), [
                        'quote_id' => $quote->id,
                        'purchase_order_no' => $quote->purchase_order_no,
                    ]);
                }
            }

            $processedItems = $this->processOrderLinesWithComments($quote, $apiResponse);

            // Store for PDFs (structure similar to ordersWithComments)
            $quotesWithComments[] = [
                'quote' => $quote,
                'processedItems' => $processedItems,
            ];

            // Store simple map for listing view (quote_id -> order_item_id -> comment)
            $itemComments = [];
            foreach ($processedItems as $processedItem) {
                $orderItem = $processedItem['orderItem'];
                $itemComments[$orderItem->id] = $processedItem['comment'] ?? null;
            }
            $quotesComments[$quote->id] = $itemComments;
        }
        
        // Fetch PaymentTermCode to determine which button to show
        $paymentTermCode = null;
        try {
            $apiUrl = 'GetCustomerDetails/' . $customer_id;
            $customerDetails = SysproService::getCustomerDetails($apiUrl);
            if (!empty($customerDetails)) {
                $paymentTermCode = data_get($customerDetails, 'PaymentTermCode') ?? data_get($customerDetails, 'Customer.PaymentTermCode');
            }
        } catch (\Exception $e) {
            Log::error('Quote Index - Error fetching customer details for PaymentTermCode: ' . $e->getMessage());
        }
        
        if ($request->has('download')) {
            $pdf = Pdf::loadView('quotes.all-quotes-pdf', [
                'quotes' => $quotes,
                'user' => $user,
                'userDetail' => $user_detail,
                'quotesWithComments' => $quotesWithComments,
            ]);
            return $pdf->download();
        } else {
            return view('quotes.index', [
                'quotes' => $quotes,
                'start_date' => $request->start_date ?? '',
                'end_date' => $request->end_date ?? '',
                'search' => $request->search_input ?? '',
                'paymentTermCode' => $paymentTermCode,
                'quotesComments' => $quotesComments,
            ]);
        }
    }
     public function store(Request $request)
    {
        $customer = getCustomer();
        if (!$customer->hasPermissionTo('getQuotes')) {
            abort(403);
        }
        // $request->validate([
        //     'customer_po_number' => ['required']
        // ], [
        //     'customer_po_number.required' => 'The PO number is required.',
        // ]);
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $price_option = "all_price";
        if ($request->has('price_option')) {
            $price_option = $request->price_option;
        }
        $total = 0;
        $orderItems = [];
        
        // Extract credit card data from request
        $cardData = null;
        if ($request->has('selected_credit_card') && !empty($request->selected_credit_card)) {
            try {
                $cardData = json_decode($request->selected_credit_card, true);
                
                // Log credit card data received
                Log::info('Quote - Credit Card Data Received:', [
                    'selected_credit_card' => $request->selected_credit_card,
                    'credit_card_last_four' => $request->credit_card_last_four,
                    'credit_card_expiry' => $request->credit_card_expiry,
                    'credit_card_type' => $request->credit_card_type,
                    'credit_card_holder_name' => $request->credit_card_holder_name,
                    'parsed_card_data' => $cardData,
                    'price_option' => $price_option,
                ]);
            } catch (\Exception $e) {
                Log::error('Quote - Failed to parse credit card data: ' . $e->getMessage());
            }
        } else {
            Log::info('Quote - No credit card data provided in request');
        }
        
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', operator: $user->id)->get();
        if ($cart->isEmpty()) {
            return redirect()->route('quotes')->with('error', 'Quote Already Generated');
        }
        $cartitems = CartItem::where('cart_id', $cart[0]->id)->get();
        DB::beginTransaction();
        $filePath = 'quotes/quote-generate' . $user->id . '.pdf';
        Storage::disk('public')->delete($filePath);
        try {
            if (empty($cart[0]->purchase_order_no)) {
                $customer_id = getCustomerId();
                $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
                $url = 'CreateQuote';
                //$order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, $request->customer_po_number ?? null, 'N', 'Y');
                $order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, 'QUOTE', 'N', 'Y', $cardData);
              
                if (!empty($order_syspro['response']['OrderNumber'])) {
                   
                    $cart[0]->update([
                        'purchase_order_no' => $order_syspro['response']['OrderNumber']
                    ]);
                    $order = Order::create([
                        'user_id' => $user->id,
                        'purchase_order_no' => $order_syspro['response']['OrderNumber'],
                        'total_items' => $cart[0]->total_items,
                        'associate_customer_id' => $customer->id ?? null,
                        'customer_number' => $customer_id
                    ]);

                    // ✅ Log the created order details
                    Log::info('Quote Created:', [
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'purchase_order_no' => $order_syspro['response']['OrderNumber'],
                        'total_items' => $cart[0]->total_items,
                        'associate_customer_id' => $customer->id ?? null,
                        'customer_number' => $customer_id,
                    ]);
                    if (!$cartitems->isEmpty()) {
                        foreach ($cartitems as $cartItem) {
                            $orderItems[] = [
                                'product_id' => $cartItem->product_id,
                                'variation_id' => $cartItem->variation_id,
                                'marked_for' => $cartItem->marked_for,
                                'msrp' => $cartItem->msrp,
                                'sku' => $cartItem->sku,
                                'price' => $cartItem->price,
                                'discount' => $cartItem->discount,
                                'discount_price' => $cartItem->discount_price,
                                'quantity' => $cartItem->quantity,
                            ];
                            $total += $cartItem->discount_price * $cartItem->quantity;
                        }
                        $order->orderItem()->createMany($orderItems);
                    }
                    $url = 'GetOrderDetails/' . $order->purchase_order_no;
                    $response = SysproService::getOrderDetails($url);
                    $order->update([
                        'status' => $response['response']['Status'],
                        'total' => $total,
                        'customer_po_number' => $response['response']['CustomerPONumber'] ?? null
                    ]);
                } elseif (!empty($order_syspro['response']['Error'])) {
                    return redirect()->back()->with('error', $order_syspro['response']['Message']);
                }
            }
           
            $customer_id = getCustomerId();
            $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            
            // Check PaymentTermCode - skip PDF generation if it's 'CC'
            // Also ensure customer_details is in session for PDF generation
            $paymentTermCode = null;
            try {
                $apiUrl = 'GetCustomerDetails/' . $customer_id;
                $customerDetails = SysproService::getCustomerDetails($apiUrl);
                if (!empty($customerDetails)) {
                    $paymentTermCode = data_get($customerDetails, 'PaymentTermCode') ?? data_get($customerDetails, 'Customer.PaymentTermCode');
                    
                    // Store customer details in session if not already there (needed for PDF generation)
                    if (!session()->has('customer_details')) {
                        session()->put('customer_details', $customerDetails);
                    }
                    
                    // Ensure customer_address is in session if not already there
                    if (!session()->has('customer_address') && !empty($customerDetails['ShipToAddresses']) && isset($customerDetails['ShipToAddresses'][0])) {
                        session()->put('customer_address', $customerDetails['ShipToAddresses'][0]);
                    }
                }
            } catch (\Exception $e) {
                Log::error('Quote - Error fetching customer details for PaymentTermCode: ' . $e->getMessage());
            }
            
            // Only generate PDF if PaymentTermCode is NOT 'CC'
            if ($paymentTermCode !== 'CC') {
                // Double-check that customer_details is in session before generating PDF
                if (!session()->has('customer_details')) {
                    Log::warning('Quote - customer_details not in session, attempting to fetch again');
                    try {
                        $apiUrl = 'GetCustomerDetails/' . $customer_id;
                        $customerDetails = SysproService::getCustomerDetails($apiUrl);
                        if (!empty($customerDetails)) {
                            session()->put('customer_details', $customerDetails);
                            if (!empty($customerDetails['ShipToAddresses']) && isset($customerDetails['ShipToAddresses'][0])) {
                                session()->put('customer_address', $customerDetails['ShipToAddresses'][0]);
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Quote - Failed to fetch customer details for PDF: ' . $e->getMessage());
                    }
                }
                
                $pdf = Pdf::loadView('pdf', ['cart' => $cart, 'user' => $user, 'userDetail' => $user_detail, 'priceOption' => $price_option]);
                $pdf->render();
                $pdfContent = $pdf->output();
                FunHelper::saveGenerateQuotePdf($pdfContent, $user);
                // Dispatch event with PDF included
                GenerateQuote::dispatch($cart, $user, $user_detail, $price_option, true);
                session()->put('downloadFile', asset('storage/' . $filePath));
            } else {
                // For CC customers, dispatch the quote event but skip PDF attachment
                GenerateQuote::dispatch($cart, $user, $user_detail, $price_option, false);
                Log::info('Quote - PDF generation skipped for CC payment term customer', [
                    'customer_id' => $customer_id,
                    'payment_term_code' => $paymentTermCode,
                ]);
            }
            
            CartItem::where('cart_id', $cart[0]->id)->delete();
            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            return redirect()->route('quotes')->with('success', 'Quote Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()->back()->with('error', 'An error occurred while placing your Quote. Please try again.');
        }
    }
    public function pdfDownloadQuote(Request $request, $quote_id)
    {
        set_time_limit(3600);
        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $price_option = "all_price";
        if ($request->has('price_option')) {
            $price_option = $request->price_option;
        }
        $cart = Order::with('user', 'orderItem.Product.Media')->where('id', $quote_id)->first();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();

        // Fetch API response to get comments for this quote
        $apiResponse = null;
        if ($cart && $cart->purchase_order_no) {
            try {
                $url = 'GetOrderDetails/' . $cart->purchase_order_no;
                $apiResponse = SysproService::getOrderDetails($url);
            } catch (\Exception $e) {
                Log::error('Failed to fetch order details for quote PDF: ' . $e->getMessage(), [
                    'quote_id' => $quote_id,
                    'purchase_order_no' => $cart->purchase_order_no,
                ]);
            }
        }

        $processedItems = $cart ? $this->processOrderLinesWithComments($cart, $apiResponse) : [];

        $pdf = Pdf::loadView('quotes.pdf-quote', [
            'cart' => $cart,
            'user' => $user,
            'userDetail' => $user_detail,
            'priceOption' => $price_option,
            'processedItems' => $processedItems,
        ]);
        $pdf->render();
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(34, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));
        return $pdf->download();
    }


    public function saveShippingAddress(Request $request)
    {
        $addresses = session('customer_details')['ShipToAddresses'];
        $key = $request->shipping_address_key;
        $get_address = array_key_exists($key, $addresses) ? $addresses[$key] : $addresses[0];
        if ($get_address) {
            session()->put('customer_address', $get_address);
            return Response::json(['success' => true, 'address' => $get_address]);
        }
        return Response::json(['success' => false]);
    }

    public function edit(Order $quote)
    {
        $url = 'GetOrderDetails/' . $quote->purchase_order_no;

        $response = SysproService::getOrderDetails($url);
        //dd($response, $quote->purchase_order_no);
        if ($response && $response['response'] && $response['response']['Line']) {
            $lines = $response['response']['Line'];
            foreach ($lines as $line) {
                $orderItem = $quote->orderItem()->where('sku', $line['StockCode'])->first();

                if ($orderItem) {
                    // Update the order item's stock field with the value from the response
                    $orderItem->update(['line_number' => $line['SalesOrderLine']]);
                }
            }
        }

        $quote = $quote->load([
            'orderItem' => function ($query) {
                $query->whereNull('action')
                    ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
            }
        ]);
        return view('quotes.edit-quote', compact('quote'));
    }

    public function updateQuoteItem(Request $request)
    {
        $user = Auth::user();
        if ($request->has('cart_item_id')) {
            $orderitems = OrderItem::where('id', $request->cart_item_id)->first();
            if ($orderitems) {
                $order = Order::where('id', $orderitems->order_id)->first();
                if ($order) {

                    if ($request->option == "increment") {
                        $order_quantity = $order->total_items + 1;
                        $orderitems->update(['quantity' => $orderitems->quantity + 1, 'action' => OrderItem::ACTION_UPDATE]);
                    } elseif ($request->option == "decrement") {
                        $order_quantity = $order->total_items - 1;

                        if ($orderitems->quantity - 1 == 0) {
                            //OrderAttribute::where('cart_item_id', $orderitems->id)->delete();
                            //$orderitems->delete();
                            $orderitems->update(['action' => OrderItem::ACTION_DELETE]);
                        } else {
                            $orderitems->update(['quantity' => $orderitems->quantity - 1, 'action' => OrderItem::ACTION_UPDATE]);
                        }
                    } elseif ($request->option == "delete") {
                        $order_quantity = $order->total_items - $orderitems->quantity;
                        //OrderAttribute::where('cart_item_id', $orderitems->id)->delete();
                        //$orderitems->delete();
                        $orderitems->update(['action' =>  OrderItem::ACTION_DELETE]);
                    } elseif ($request->option == 'updateQuantity') {
                        if ($request->quantity != 0 && !empty($request->quantity)) {
                            $orderitems->update(['quantity' => $request->quantity]);
                            $order_quantity = CartItem::where('cart_id', $order->id)->sum('quantity');
                        }
                    }
                    $order->update(['total_items' => $order_quantity]);
                }
            }
        }
        //$order = $order->load('orderItem');
        $order = $order->load([
            'orderItem' => function ($query) {
                $query->whereNull('action')
                    ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
            }
        ]);
        return view('components.cart.quote-product-list', ['page' => 'cart', 'quote' => $order]);
    }

    public function updateQuoteItemMarked(Request $request)
    {
        if ($request->has('cart_item_id')) {
            $cartitems = OrderItem::where('id', $request->cart_item_id)->first();
            if ($cartitems) {
                $cartitems->update(['marked_for' => $request->marked_for]);
            }
        }
    }

    public function addToQuote(Request $request,  $id)
    {
        $user = Auth::user();
        $sku = $request->sku;
        if ($request->has('product_id')) {
            $product = Product::where('id', $request->product_id)->first();
            $variations = [];
            $skuExists = false;
            if ($product) {  // Check if $product is not null
                if (!empty($product->variation)) {
                    $variations = $product->variation->pluck('sku')->toArray();
                }

                $skuExists = in_array($request->sku, $variations) || ($product->sku === $request->sku);
            } else {
                return response()->json(['success' => false, 'message' => 'Product not found.']);
            }

            $order = order::where('id', $id)->first();
            if (!empty(auth()->user()->default_customer_id) && $skuExists) {
                $customer_id = getCustomerId();
                $url = 'GetCustomerDetails/' . $customer_id;
                $syspro_products = SysproService::getCustomerDetails($url);
                if (!empty($syspro_products['PriceList'])) {
                    session()->put('customer_details', $syspro_products);
                    $product['discount'] = $syspro_products['CustomerDiscountPercentage'];
                    $isStockItem = false;
                    $existingKey = array_search($request->sku, array_column($syspro_products['PriceList'], 'StockCode'));
                    if (!empty($existingKey)) {
                        $product->price = $syspro_products['PriceList'][$existingKey]['DealerPrice'];
                        $product->msrp = $syspro_products['PriceList'][$existingKey]['MSRPPrice'];
                        $product->sku = $syspro_products['PriceList'][$existingKey]['StockCode'];
                        $isStockItem = true;
                    }
                    if (!$isStockItem) {
                        return response()->json(['success' => false, 'message' => 'Non-Stock Item Cannot be Added To Cart']);
                    }
                }
            }
            if ($order) {
                $order->update(['total_items' => $order->total_items + $request->qty]);
            } else {
                $order = order::create([
                    'user_id' => $user->id,
                    'total_items' => $request->qty,
                ]);
            }

            if ($request->variation_id && $request->variation_id != '') {
                $orderitems = OrderItem::where('order_id', $order->id)
                    ->where('product_id', $request->product_id)
                    ->where('variation_id', $request->variation_id)
                    ->where(function ($query) {
                        $query->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    })
                    ->first();
                $var_id = $request->variation_id;
            } else {
                $orderitems = OrderItem::where('order_id', $order->id)
                    ->where('product_id', $request->product_id)
                    ->where('sku', $product->sku ?? '')
                    ->where(function ($query) {
                        $query->whereNull('action')
                            ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                    })
                    ->first();
                $var_id = NULL;
            }
            if ($orderitems) {
                $orderitems->update(['quantity' => $orderitems->quantity + $request->qty]);
            } else {
                if ($product['discount'] != '' && $product['discount'] > 0) {
                    $product['discount_in_price'] = round(($product['price'] * $product['discount']) / 100, 2);
                    $product['discount_price'] = ($product['price'] - $product['discount_in_price']);
                } else {
                    $product['discount_price'] = $product['price'];
                }
                $orderitems = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $request->product_id,
                    'variation_id' => $var_id,
                    'sku' => $product->sku ?? '',
                    'msrp' => $product->msrp ?? null,
                    'price' => $product->price,
                    'discount' => $product['discount_in_price'] ?? 0,
                    'discount_price' => $product['discount_price'],
                    'quantity' => $request->qty,
                    'action' => 'A'
                ]);
            }
        }
        //$order = $order->load('orderItem');
        $order = $order->load([
            'orderItem' => function ($query) {
                $query->whereNull('action')
                    ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
            }
        ]);
        return view('components.cart.quote-product-list', ['page' => 'cart', 'quote' => $order]);
    }

    public function update(Request $request, $id)
    {
        $customer = getCustomer();

        $user = Auth::user()->load(['associateCustomers', 'getUserDetails']);
        $price_option = "all_price";
        if ($request->has('price_option')) {
            $price_option = $request->price_option;
        }
        $total = 0;
        $orderItems = [];
        $order = order::where('id', $id)->first();
        if (!$order) {
            return redirect()->route('quotes')->with('error', 'Quote Already Generated');
        }
        $orderitems = OrderItem::where('order_id', $id)->get();
        DB::beginTransaction();
        $filePath = 'quotes/quote-generate' . $user->id . '.pdf';
        Storage::disk('public')->delete($filePath);
        try {
            if (empty($order->purchase_order_no)) {
                $customer_id = getCustomerId();
                $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
                $url = 'UpdateQuote';
                //$order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, $request->customer_po_number ?? null, 'N', 'Y');
                $order_syspro = SysproService::updateQuote($order->purchase_order_no, $url, $orderitems, 'QUOTE', 'N', 'Y');

                if (!empty($order_syspro['response']['OrderNumber'])) {

                    // $order = Order::create([
                    //     'user_id' => $user->id,
                    //     'purchase_order_no' => $order_syspro['response']['orderNumber'],
                    //     'total_items' => $cart[0]->total_items,
                    //     'associate_customer_id' => $customer->id ?? null,
                    //     'customer_number' => $customer_id
                    // ]);

                    // ✅ Log the created order details
                    Log::info('Quote Updated:', [
                        'order_id' => $order->id,
                        'user_id' => $user->id,
                        'purchase_order_no' => $order_syspro['response']['OrderNumber'],
                        'total_items' => $order->total_items,
                        'associate_customer_id' => $customer->id ?? null,
                        'customer_number' => $customer_id,
                    ]);
                    if (!$orderitems->isEmpty()) {
                        foreach ($orderitems as $orderitem) {
                            if ($orderitem->action != "D") {

                                $total += $orderitem->discount_price * $orderitem->quantity;
                            }
                        }
                        $order->orderItem()->createMany($orderItems);
                    }
                    $url = 'GetOrderDetails/' . $order->purchase_order_no;
                    $response = SysproService::getOrderDetails($url);

                    if ($response && $response['response']['Line']) {
                        $lines = $response['response']['Line'];

                        foreach ($lines as $line) {
                            $orderItem = $order->orderItem()->where('sku', $line['StockCode'])->first();

                            if ($orderItem) {

                                $orderItem->update(['line_number' => $line['SalesOrderLine'], 'action' => 'N']);
                            }
                        }
                        $orderItemsToDelete = $order->orderItem()->where('action', 'D')->delete();
                    }

                    $order->update([
                        'status' => $response['response']['Status'],
                        'total' => $total,
                        //'customer_po_number' => $request->customer_po_number ?? null
                    ]);
                } elseif (!empty($order_syspro['response']['Error'])) {
                    return redirect()->back()->with('error', $order_syspro['response']['Message']);
                }
            }
            $customer_id = getCustomerId();
            $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            // $pdf = Pdf::loadView('pdf', ['cart' => $cart, 'user' => $user, 'userDetail' => $user_detail, 'priceOption' => $price_option]);
            //$pdf->render();
            // $pdfContent = $pdf->output();
            // FunHelper::saveGenerateQuotePdf($pdfContent, $user);
            // GenerateQuote::dispatch($cart, $user, $user_detail, $price_option);
            //CartItem::where('cart_id', $cart[0]->id)->delete();
            //Cart::where('user_id', $user->id)->delete();
            // session()->put('downloadFile', asset('storage/' . $filePath));
            DB::commit();
            return redirect()->route('quotes')->with('success', 'Quote Update Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote creation failed: ' . $e->getMessage());
            //dd($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your Quote. Please try again.');
        }
    }

    /**
     * Process order/quote lines from API response to combine products with comments
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
                $lineType = isset($line['LineType']) ? (string) $line['LineType'] : '';

                // If it's a product line (LineType = "1")
                if ($lineType === '1' && !empty($line['StockCode'])) {
                    $sku = $line['StockCode'];

                    // Check if next line is a comment for this product
                    if ($i + 1 < count($lines)) {
                        $nextLine = $lines[$i + 1];
                        $nextLineType = isset($nextLine['LineType']) ? (string) $nextLine['LineType'] : '';

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
                    'comment' => $commentsBySku[$item->sku] ?? null,
                ];
            }
        } else {
            // Fallback: if no API response, just use order items without comments
            foreach ($orderItems as $item) {
                $processedItems[] = [
                    'orderItem' => $item,
                    'comment' => null,
                ];
            }
        }

        return $processedItems;
    }

    /**
     * Convert quote items to cart and redirect to shipping page
     */
    public function placeOrderFromQuote($quote_id)
    {
        $user = Auth::user();
        $quote = Order::with([
            'OrderItem' => function ($query) {
                $query->where(function ($q) {
                    $q->whereNull('action')
                        ->orWhere('action', '!=', OrderItem::ACTION_DELETE);
                });
            },
            'OrderItem.Product.Media'
        ])->where('id', $quote_id)->first();

        if (!$quote) {
            return redirect()->route('quotes')->with('error', 'Quote not found.');
        }

        // Check if user has permission
        $customer = getCustomer();
        if (!$customer->hasPermissionTo('placeOrders')) {
            return redirect()->route('quotes')->with('error', 'You do not have permission to place orders.');
        }

        // Check if customer is CC customer - for CC customers, don't pre-populate PO number
        // so they are prompted to enter their customer PO number on checkout page
        $customerDetails = session('customer_details', []);
        $paymentTermCode = data_get($customerDetails, 'PaymentTermCode') ?? data_get($customerDetails, 'Customer.PaymentTermCode');
        $isCCCustomer = isset($paymentTermCode) && $paymentTermCode === 'CC';

        try {
            DB::beginTransaction();

            // Delete existing cart items for this user
            $existingCart = Cart::where('user_id', $user->id)->first();
            if ($existingCart) {
                CartItem::where('cart_id', $existingCart->id)->delete();
                $existingCart->delete();
            }

            // Create a new cart
            // For CC customers, set purchase_order_no to null so they are prompted to enter
            // their customer PO number on the checkout page (like normal orders)
            $cart = Cart::create([
                'user_id' => $user->id,
                'total_items' => $quote->total_items,
                'purchase_order_no' => $isCCCustomer ? null : ($quote->purchase_order_no ?? null),
            ]);

            // Convert quote items to cart items
            $quoteItems = $quote->OrderItem;
            foreach ($quoteItems as $quoteItem) {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $quoteItem->product_id,
                    'variation_id' => $quoteItem->variation_id,
                    'marked_for' => $quoteItem->marked_for,
                    'msrp' => $quoteItem->msrp,
                    'sku' => $quoteItem->sku,
                    'price' => $quoteItem->price,
                    'discount' => $quoteItem->discount,
                    'discount_price' => $quoteItem->discount_price,
                    'quantity' => $quoteItem->quantity,
                ]);
            }

            // Store quote ID in session so we know it's from a quote
            session()->put('quote_id', $quote_id);
            session()->put('quote_purchase_order_no', $quote->purchase_order_no);

            DB::commit();

            // Redirect to shipping page
            return redirect()->route('shipping');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error converting quote to cart: ' . $e->getMessage());
            return redirect()->route('quotes')->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}
