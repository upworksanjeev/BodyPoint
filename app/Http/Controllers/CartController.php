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
use Illuminate\Support\Facades\URL;
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
			$cartitems->update(['quantity' => $cartitems->quantity+1,'price' => $request->price,'discount' => $request->discount,'discount_price' => $request->discount_price]);
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
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		return view('quick-entry', array(
				'cart' => $cart,
			));
			
	}
  
	/**
     * update cart item details
     */
    public function updateCartItem(Request $request)
    {
		$user = Auth::user();
		if($request->has('cart_item_id')){
			$cartitems=CartItem::where('id', $request->cart_item_id)->first();
			if($cartitems){
				$cart=Cart::where('id', $cartitems->cart_id)->first();
					if($cart){
						
						if($request->option=="increment"){
							$cart_quantity=$cart->total_items+1;
							$cartitems->update(['quantity' => $cartitems->quantity+1]); 
						}elseif($request->option=="decrement"){
							$cart_quantity=$cart->total_items-1;
							 
							if($cartitems->quantity-1==0){
								CartAttribute::where('cart_item_id', $cartitems->id)->delete();
								$cartitems->delete(); 
							}else{
								$cartitems->update(['quantity' => $cartitems->quantity-1]);
							}
						}elseif($request->option=="delete"){
							$cart_quantity=$cart->total_items-$cartitems->quantity;
							CartAttribute::where('cart_item_id', $cartitems->id)->delete();
							$cartitems->delete(); 
						}	
					    $cart->update(['total_items' => $cart_quantity]);						
					}	
				}
		}
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		return view('components.cart.product-list ', ['page' => 'cart','cart' => $cart]);
	} 
	
	
	/**
     * update cart item marked_for details
     */
    public function updateCartItemMarked(Request $request)
    {
		if($request->has('cart_item_id')){
			$cartitems=CartItem::where('id', $request->cart_item_id)->first();
			if($cartitems){
				$cartitems->update(['marked_for' => $request->marked_for]);
			}
		}
	} 
	
	/**
     * Delete all cart items
     **/
    public function deleteCart(Request $request)
    {
		$user = Auth::user();
		if($request->has('cart_id')){
			$cart=Cart::where('id', $request->cart_id)->first();
			if($cart){
				$cartitems=CartItem::where('cart_id', $cart->id)->get();
				if($cartitems && count($cartitems)>0){
					foreach($cartitems as $v){
						CartAttribute::where('cart_item_id', $v->id)->delete();
						CartItem::where('id', $v->id)->delete(); 
					}
				}
				$cart->delete(); 
			}
		}				
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		return view('components.cart.product-list ', ['page' =>  'cart','cart' => $cart]);
	} 
	
	/**
     * update cart item count in header
     */
    public function getCartCount(Request $request)
    {
		return view('components.cart.cart-count');
	} 
	
	/**
     * search product list in name and stockcode
     */
    public function searchProduct(Request $request)
    {
		$product=Product::where('sku', 'like', '%'.$request->keys.'%')->orWhere('name', 'like', '%'.$request->keys.'%')->get();
		$data='';
		if($product){
			$data='<thead class="header"><tr><th style="width:60%;">Stock Code</th><th style="width:40%;">Name</th></tr></thead><tbody>';
			foreach($product as $k=>$v){
				$data.='<tr class="cursor-pointer" onclick="chooseProduct(\''.$v->sku.'\','.$v->id.')"><td>'.$v->sku.'</td><td>'.$v->name.'</td></tr>';
			}
			$data.='</tbody>';
		}
		return $data;
	} 
	
	
	/**
     * Add product into cart
     */
    public function addToCart(Request $request)
    {   
		$user = Auth::user();
		if($request->has('product_id')){
		$cart=Cart::where('user_id', $user->id)->first();
		if($cart){
			$cart->update(['total_items' => $cart->total_items+$request->qty]);
		}else{
			$cart=Cart::create([
				'user_id' => $user->id,
				'total_items' => $request->qty,
			]);
		}
		$cartitems=CartItem::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();
		if($cartitems){
			$cartitems->update(['quantity' => $cartitems->quantity+$request->qty]);
		}else{
			$product=Product::where('id', $request->product_id)->first();
			if($product['discount']!='' && $product['discount']>0){
				$product['discount_in_price']=round(($product['price']*$product['discount'])/100,2);
				$product['discount_price']=($product['price']-$product['discount_in_price']);
			}else{
				$product['discount_price']=$product['price'];
			}
			$cartitem=CartItem::create([
					'cart_id' => $cart->id,
					'product_id' => $request->product_id,
					'price' => $product->price,
					'discount' => $product['discount_in_price']??0,
					'discount_price' => $product['discount_price'],
					'quantity' => $request->qty,
				]);
			}
		}
	
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		return view('components.cart.product-list ', ['page' => 'quick-entry','cart' => $cart]);
	} 
}
