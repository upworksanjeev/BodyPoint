<?php

namespace App\Http\Controllers\Quote;

use App\Events\GenerateQuote;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\UserDetails;
use App\Services\SysproService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($request->start_date != '') {
            $start_date = date('y-m-d 00:00:01', strtotime($request->start_date));
        }
        if ($request->end_date != '') {
            $end_date = date('y-m-d 23:59:59', strtotime($request->end_date));
        }
        if ($request->search_input != '' && $request->start_date != '' && $request->end_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->get();
        } elseif ($request->search_input != '' && $request->start_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '>=', $start_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")->get();
        } elseif ($request->start_date != '' && $request->end_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '>=', $start_date)
                ->where('created_at', '<=', $end_date)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->search_input != '' && $request->end_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '<=', $end_date)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->search_input != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('purchase_order_no', 'like', "%" . $request->search_input . "%")
                ->orWhere('bp_number', 'like', "%" . $request->search_input . "%")
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->start_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '>=', $start_date)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($request->end_date != '') {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('created_at', '<=', $end_date)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $quotes = Order::with('User', 'OrderItem.Product.Media')
                ->where('user_id', $user->id)
                ->where('status', 'F')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $user_detail = UserDetails::where('user_id', $user->id)->first();
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
        $user = Auth::user();
        $price_option = "all_price";
        if ($request->has('price_option')) {
            $price_option = $request->price_option;
        }
        $cart = Cart::with('User', 'CartItem.Product.Media')->where('user_id', operator: $user->id)->get();
        $cartitems = CartItem::where('cart_id', $cart[0]->id)->get();
        DB::beginTransaction();
        try {
            if (empty($cart->purchase_order_no)) {
                $url = 'CreateQuote';
                $order_syspro = SysproService::placeQuoteWithOrder($url, $cartitems, NULL, 'N');
                if (!empty($order_syspro['response']['orderNumber'])) {
                    $cart[0]->update([
                        'purchase_order_no' => $order_syspro['response']['orderNumber']
                    ]);
                    $order = Order::create([
                        'user_id' => $user->id,
                        'purchase_order_no' => $order_syspro['response']['orderNumber'],
                        'total_items' => $cart[0]->total_items
                    ]);
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
                        $url = 'GetOrderDetails/' . $order->purchase_order_no;
                        $response = SysproService::getOrderDetails($url);
                        $order->update([
                            'status' => $response['response']['Status'],
                        ]);
                    }
                } elseif (!empty($order_syspro['response']['Error'])) {
                    return redirect()->back()->with('error', $order_syspro['response']['Message']);
                }
            }
            $user_detail = UserDetails::where('user_id', $user->id)->first();
            GenerateQuote::dispatch($cart, $user, $user_detail, $price_option);
            CartItem::where('cart_id', $cart[0]->id)->delete();
            Cart::where('user_id', $user->id)->delete();
            DB::commit();
            return redirect()->route('quotes')->with('success', 'Quote Created Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Quote creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while placing your Quote. Please try again.');
        }
    }
}
