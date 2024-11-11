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
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
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

        return view('payment', array(
            'cart' => $cart,
        ));
    }

    /**
     * checkout page cart details.
     */
    public function checkout(Request $request)
    {
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
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
            ));
        }
        return redirect()->route('cart');
    }

    /**
     * quote page cart details.
     */
    public function quote(Request $request)
    {
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', $user->id)->get();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        return view('quote', array(
            'cart' => $cart,
            'user' => $user,
            'user_detail' => $user_detail,
        ));
    }

    /**
     * Save Order in DB
     */
    public function saveOrder(Request $request)
    {
        $request->validate([
            'customer_po_number' => ['required']
        ], [
            'customer_po_number.required' => 'The PO number is required.',
        ]);
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
        $total = 0;
        if (!$request->has('cart_id')) {
            return redirect()->route('cart')->with('error', 'Cart ID is missing.');
        }
        $cart = Cart::where('id', $request->cart_id)->first();
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Cart not found.');
        }
        DB::beginTransaction();
        try {
            $customer_id = getCustomerId();
            $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            $order = Order::create([
                'user_id' => $cart->user_id,
                'purchase_order_no' => $request->purchase_order_no,
                'total_items' => $cart->total_items,
                'associate_customer_id' => $customer->id ?? null,
                'customer_number' => $customer_id,
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
            $order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, $request->customer_po_number);
            if (!empty($order_syspro['response']['orderNumber'])) {
                $order->update([
                    'purchase_order_no' => $order_syspro['response']['orderNumber'],
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
                return redirect()->back()->with('error', $order_syspro['response']['Message']);
            }
            $customer_id = getCustomerId();
            $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            $pdf = Pdf::loadView('order-receipt', ['order' => $order, 'user' => $user, 'userDetail' => $user_detail]);
            $pdfContent = $pdf->output();
            FunHelper::saveOrderPlacedPdf($pdfContent, $order);
            OrderPlaced::dispatch($order);
            CartItem::where('cart_id', $cart->id)->delete();
            $cart->delete();
            DB::commit();
            return view('order-thank-you', ['order' => $order]);
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
        $user = Auth::user();
        $customer_number = session('customer_id') ?? auth()->user()->default_customer_id;
        if ($request->start_date != '') {
            $start_date = date('y-m-d 00:00:01', strtotime($request->start_date));
        }
        if ($request->end_date != '') {
            $end_date = date('y-m-d 23:59:59', strtotime($request->end_date));
        }
        if ($request->search_input != '' && $request->start_date != '' && $request->end_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->where('status','!=','F')->orderBy('created_at','desc')->get();
        } elseif ($request->search_input != '' && $request->start_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at', '>=', $start_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->get();
        } elseif ($request->start_date != '' && $request->end_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->where('status','!=','F')->orWhereNull('status')->orderBy('created_at','desc')->get();
        } elseif ($request->search_input != '' && $request->end_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('created_at', '<=', $end_date)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->where('status','!=','F')->orderBy('created_at','desc')->get();
        } elseif ($request->search_input != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('purchase_order_no', 'like', "%" . $request->search_input . "%")->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->where('status','!=','F')->orderBy('created_at','desc')->get();
        } elseif ($request->start_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('created_at', '>=', $start_date)->where('status','!=','F')->orderBy('created_at','desc')->get();
        } elseif ($request->end_date != '') {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('created_at', '<=', $end_date)->where('status','!=','F')->orderBy('created_at','desc')->get();
        } else {
            $order = Order::with('User', 'OrderItem.Product.Media')->where('user_id', $user->id)->where('customer_number',$customer_number)->where('status','!=','F')->orderBy('created_at','desc')->get();
        }
        $user_detail = UserDetails::where('user_id', $user->id)->first();
        if ($request->has('download')) {
            $pdf = Pdf::loadView('all-order-receipt', ['orders' => $order, 'user' => $user, 'userDetail' => $user_detail]);
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
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
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
        GenerateQuote::dispatch($cart, $user, $user_detail, $price_option);
        $dompdf = $pdf->getDomPDF();
        $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(34, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));
        return $pdf->download();
    }

    /**
     *  receipt download for orders
     */
    public function receiptDownload(Request $request)
    {
        set_time_limit(3600);
        $user = Auth::user()->load(['associateCustomers','getUserDetails']);
        $order = Order::with('User', 'OrderItem.Product.Media')->where('id', $request->order_id)->first();
        $customer_id = getCustomerId();
        $user_detail = $user->associateCustomers()->where('customer_id', $customer_id)->first();
        $pdf = Pdf::loadView('order-receipt', ['order' => $order, 'user' => $user, 'userDetail' => $user_detail]);
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
}
