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
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->get();
        } elseif ($request->search_input != '' && $request->start_date != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->get();
        } elseif ($request->start_date != '' && $request->end_date != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->search_input != '' && $request->end_date != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->search_input != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->start_date != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '>=', $start_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->end_date != '') {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->where('created_at', '<=', $end_date)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $quotes =Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('customer_number', $customer_number)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        if ($request->has('download')) {
            $pdf = Pdf::loadView('quotes.all-quotes-pdf', ['quotes' => $quotes, 'user' => $user, 'userDetail' => $user_detail]);
            return $pdf->download();
        } else {
            return view('quotes.index', [
                'quotes' => $quotes,
                'start_date' => $request->start_date ?? '',
                'end_date' => $request->end_date ?? '',
                'search' => $request->search_input ?? '',
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
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', operator: $user->id)->get();
        if ($cart->isEmpty()) {
            return redirect()->route('quotes')->with('error', 'Quote Already Generated');
        }
        $cartitems = CartItem::where('cart_id', $cart[0]->id)->get();
        DB::beginTransaction();
        $filePath = 'quotes/quote-generate' . $user->id . '.pdf';
        Storage::disk('public')->delete($filePath);
        try {
            if (empty($cart->purchase_order_no)) {
                $customer_id = getCustomerId();
                $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
                $url = 'CreateQuote';
                //$order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, $request->customer_po_number ?? null, 'N', 'Y');
                $order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, 'QUOTE', 'N', 'Y');
               
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
            $pdf = Pdf::loadView('pdf', ['cart' => $cart, 'user' => $user, 'userDetail' => $user_detail, 'priceOption' => $price_option]);
            $pdf->render();
            $pdfContent = $pdf->output();
            FunHelper::saveGenerateQuotePdf($pdfContent, $user);
            GenerateQuote::dispatch($cart, $user, $user_detail, $price_option);
            CartItem::where('cart_id', $cart[0]->id)->delete();
            Cart::where('user_id', $user->id)->delete();
            session()->put('downloadFile', asset('storage/' . $filePath));
            DB::commit();
            return redirect()->route('quotes')->with('success', 'Quote Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote creation failed: ' . $e->getMessage());
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
        $pdf = Pdf::loadView('quotes.pdf-quote', ['cart' => $cart, 'user' => $user, 'userDetail' => $user_detail, 'priceOption' => $price_option]);
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
        $url = 'GetOrderDetails/'. $quote->purchase_order_no;
        
        $response = SysproService::getOrderDetails($url);
        
        if($response && $response['response']['Line']){
           $lines = $response['response']['Line'];
            foreach($lines as $line){
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
            if (empty($cart->purchase_order_no)) {
                $customer_id = getCustomerId();
                $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
                $url = 'UpdateQupte';
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
                            if($orderitem->action != "D"){
                                
                                $total += $orderitem->discount_price * $orderitem->quantity;
                            }
                        }
                        $order->orderItem()->createMany($orderItems);
                    }
                    $url = 'GetOrderDetails/' . $order->purchase_order_no;
                    $response = SysproService::getOrderDetails($url);
                    
                    if($response && $response['response']['Line']){
                        $lines = $response['response']['Line'];
                       
                         foreach($lines as $line){
                             $orderItem = $order->orderItem()->where('sku', $line['StockCode'])->first();
                         
                             if ($orderItem) {
                                
                                 $orderItem->update(['line_number' => $line['SalesOrderLine'], 'action' => 'N']);
                             }
                         }
                         $orderItemsToDelete = $order->orderItem() ->where('action', 'D')->delete();
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
}
