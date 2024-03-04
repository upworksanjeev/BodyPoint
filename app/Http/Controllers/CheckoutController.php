<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\CartAttribute;
use App\Models\OrderAttribute;
use Illuminate\Support\Str;
use Auth;

class CheckoutController extends Controller
{
     /**
     *  Shipping details.
     */
    public function index(Request $request)
    {
		$user = Auth::user();
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
	
		return view('shipping', array(
				'cart' => $cart,
			));
	} 
	
	/**
     * Payment select page.
     */
    public function payment(Request $request)
    {
		$user = Auth::user();
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
	
		return view('payment', array(
				'cart' => $cart,
			));
	}

	/**
     * checkout page cart details.
     */
    public function checkout(Request $request)
    {
		$user = Auth::user();
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
	
		return view('checkout', array(
				'cart' => $cart,
			));
	} 

	 /**
     * Save Order in DB
     */
    public function saveOrder(Request $request)
    {
		$user = Auth::user();
		if($request->has('cart_id')){
		$cart=Cart::where('id', $request->cart_id)->first();
		if($cart){
			$order=Order::create([
				'user_id' => $cart->user_id,
				'purchase_order_no' => $request->purchase_order_no?$request->purchase_order_no:rand(5,10),
				'total_items' => $cart->total_items,
			]);
			
		$cartitems=CartItem::where('cart_id', $cart->id)->get();
		if($cartitems){ 	
			foreach($cartitems as $k=>$v){
				$order_item=OrderItem::create([
						'order_id' => $order->id,
						'product_id' => $v->product_id,
						'marked_for' => $v->marked_for,
						'price' => $v->price,
						'discount' => $v->discount,
						'discount_price' => $v->discount_price,
						'quantity' => $v->quantity,
					]);
			}
			
		}
		CartItem::where('cart_id', $cart->id)->delete();
		$cart->delete();
		}
		}
		$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->get();
		return view('order-thank-you', array(
				'order' => $order,
			));
			
	} 
	 
	 /**
     * get all Orders 
     */
    public function myOrder(Request $request)
    {
		$user = Auth::user();
		$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->get();
		return view('order', array(
				'order' => $order,
			));
	} 
	 
	
}
