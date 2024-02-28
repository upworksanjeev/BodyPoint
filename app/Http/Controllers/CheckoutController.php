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

	
	
	
}
