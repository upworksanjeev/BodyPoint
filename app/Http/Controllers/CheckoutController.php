<?php

namespace App\Http\Controllers;


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
		$user_detail=UserDetails::where('user_id', $user->id)->first();
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
		if(isset($cart[0])){
		$user_detail=UserDetails::where('user_id', $user->id)->first();
		$string = uniqid(rand());
		$purchase_order_no = $cart[0]['purchase_order_no']?$cart[0]['purchase_order_no']:substr($string, 0, 10);
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
		$user = Auth::user();
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		$user_detail=UserDetails::where('user_id', $user->id)->first();
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
		$user = Auth::user();
		if($request->has('cart_id')){
		$cart=Cart::where('id', $request->cart_id)->first();
		if($cart){
			$order=Order::create([
				'user_id' => $cart->user_id,
				'purchase_order_no' => $request->purchase_order_no,
				'total_items' => $cart->total_items,
			]);
			
		$cartitems=CartItem::where('cart_id', $cart->id)->get();
		if($cartitems){ 	
			foreach($cartitems as $k=>$v){
				$order_item=OrderItem::create([
						'order_id' => $order->id,
						'product_id' => $v->product_id,
						'variation_id' => $v->variation_id,
						'marked_for' => $v->marked_for,
						'msrp' => $v->msrp,
						'sku' => $v->sku,
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
		$order=Order::with('User','OrderItem.Product.Media')->where('id', $order->id)->first();
		return view('order-thank-you', array(
				'order' => $order,
			));
		}
		return redirect()->route('cart');		
			
	} 
	 
	 /**
     * get all Orders 
     */
    public function myOrder(Request $request)
    {
		$user = Auth::user();
		if($request->start_date!=''){ $start_date=date('y-m-d 00:00:01',strtotime($request->start_date)); }
		if($request->end_date!=''){ $end_date=date('y-m-d 23:59:59',strtotime($request->end_date)); }
		if($request->search_input!='' && $request->start_date!='' && $request->end_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','>=', $start_date)->where('created_at','<=', $end_date)->where('purchase_order_no','like', "%".$request->search_input."%")->orWhere('bp_number','like', "%".$request->search_input."%")->get();
		}elseif($request->search_input!='' && $request->start_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','>=', $start_date)->where('purchase_order_no','like', "%".$request->search_input."%")->orWhere('bp_number','like', "%".$request->search_input."%")->get();
		}elseif($request->start_date!='' && $request->end_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','>=', $start_date)->where('created_at','<=', $end_date)->get();
		}elseif($request->search_input!='' && $request->end_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','<=', $end_date)->where('purchase_order_no','like', "%".$request->search_input."%")->orWhere('bp_number','like', "%".$request->search_input."%")->get();
		}elseif($request->search_input!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('purchase_order_no','like', "%".$request->search_input."%")->orWhere('bp_number','like', "%".$request->search_input."%")->get();
		}elseif($request->start_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','>=', $start_date)->get();
		}elseif($request->end_date!=''){
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->where('created_at','<=', $end_date)->get();
		}else{
			$order=Order::with('User','OrderItem.Product.Media')->where('user_id', $user->id)->get();
		}
		$user_detail=UserDetails::where('user_id', $user->id)->first();
		if($request->has('download')){
			$pdf = Pdf::loadView('all-order-receipt', ['orders' => $order,'user' => $user,'userDetail' => $user_detail]);
			return $pdf->download();
		}else{
		return view('order', array(
				'order' => $order,
				'start_date' => $request->start_date??'',
				'end_date' => $request->end_date??'',
				'search' => $request->search_input??'',
			));
			
		}
		
	} 
	
	/**
	*  PDF download for save quote
	*/
	public function pdfDownload(Request $request){
		set_time_limit(3600);
		$user = Auth::user();
		$price_option="all_price";
		if($request->has('price_option')){
		$price_option=$request->price_option; }
		$cart=Cart::with('User','CartItem.Product.Media')->where('user_id', $user->id)->get();
		$user_detail=UserDetails::where('user_id', $user->id)->first();
		$pdf = Pdf::loadView('pdf', ['cart' => $cart,'user' => $user,'userDetail' => $user_detail,'priceOption' => $price_option]);
		$pdf->render();
		$dompdf = $pdf->getDomPDF();
		$font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
        $dompdf->get_canvas()->page_text(34, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
		return $pdf->download();
	}
	
	/**
	*  receipt download for orders
	*/
	public function receiptDownload(Request $request){
		set_time_limit(3600);
		$user = Auth::user();
		$order=Order::with('User','OrderItem.Product.Media')->where('id', $request->order_id)->first();
		$user_detail=UserDetails::where('user_id', $user->id)->first();
		$pdf = Pdf::loadView('order-receipt', ['order' => $order,'user' => $user,'userDetail' => $user_detail]);
		return $pdf->download();
	}
	 
	 /**
     * Update Purchase No in cart table
     **/
    public function updatePurchaseNo(Request $request)
    {
		if($request->has('cart_id')){
			Cart::where('id', $request->cart_id)->update(['purchase_order_no' => $request->purchase_order_no]);
		}
	} 

}
