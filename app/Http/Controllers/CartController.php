<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\CartAttribute;
use Illuminate\Support\Str;
use Auth;

class CartController extends Controller
{
     /**
     * Add to cart and display cart details.
     */
    public function index(Request $request)
    {
		$user = Auth::user();
		
		if($request->has('product_id')){
		$cart=Cart::where('user_id', $user->id)->first();
		if($cart){
			$cart->update(['total_items' => $cart->total_items+1]);
		}else{
			$cart=Cart::create([
				'user_id' => $user->id,
				'total_items' => 1,
			]);
		}
		$cartitems=CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();
		if($cartitems){
			$cartitems->update(['quantity' => $cartitems->quantity+1]);
		}else{
			$cartitem=CartItem::create([
					'cart_id' => $cart->id,
					'product_id' => $request->product_id,
					'price' => $request->price,
					'discount' => $request->discount,
					'discount_price' => $request->discount_price,
					'quantity' => 1,
				]);
			}
		}
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		return view('cart', array(
				'cart' => $cart,
			));
			
	} 
	
	 /**
     *  Quick Order Entry details
     */
	public function quickEntry(Request $request)
    {
		$user = Auth::user();
		
		if($request->has('product_id')){
		$cart=Cart::where('user_id', $user->id)->first();
		if($cart){
			$cart->update(['total_items' => $cart->total_items+1]);
		}else{
			$cart=Cart::create([
				'user_id' => $user->id,
				'total_items' => 1,
			]);
		}
		$cartitems=CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();
		if($cartitems){
			
			$cartitems->update(['quantity' => $cartitems->quantity+1]);
		}else{
			$cartitem=CartItem::create([
					'cart_id' => $cart->id,
					'product_id' => $request->product_id,
					'price' => $request->price,
					'discount' => $request->discount,
					'discount_price' => $request->discount_price,
					'quantity' => 1,
				]);
			}
		}
	
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
	

		return view('quick-entry', array(
				'cart' => $cart,
			));
			
	}
  
}
