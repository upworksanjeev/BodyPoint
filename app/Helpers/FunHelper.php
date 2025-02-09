<?php
namespace App\Helpers;
use App\Models\Category;
use App\Models\Cart;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FunHelper
{
	 public static function instance()
     {
         return new FunHelper();
     }

	 public static function getCartCount()
     {
		$user = Auth::user();
		if(isset($user->id)){
		$cart_count=Cart::where('user_id', $user->id)->select('total_items')->first(); }
		return $cart_count->total_items??'';
	 }

	 public static function getUserProfile()
     {
		$user = Auth::user();
		if(isset($user->id)){
		$user_detail=UserDetails::where('user_id', $user->id)->select('profile_img')->first(); }
		return $user_detail->profile_img??'';
	 }

	 public static function getMenu()
     {
		    $cat_array=[];
            $categories = Category::where('parent_cat_id',0)->get();
			$i=0;
			foreach($categories as $k => $v){
				$cat_array[$i]['parent_cat']=$v['name'];
				$cat_array[$i]['image']=$v['image'];
				$subcategory = Category::where('parent_cat_id',$v['id'])->get();
				foreach($categories as $k => $v){
					$cat_array[$i]['sub_cat'][]=$v['name'];
				}
				$i++;
			}
			return($cat_array);
     }

	 public static function saveOrderPlacedPdf($pdfContent,$order){
		$directory = 'orders';
		$filename = 'order_receipt_' . $order->id . '.pdf';
		$path = $directory . '/' . $filename;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
		Storage::disk('public')->put($path, $pdfContent);
	 }

     public static function saveGenerateQuotePdf($pdfContent,$user){
		$directory = 'quotes';
		$filename = 'quote-generate' . $user->id . '.pdf';
		$path = $directory . '/' . $filename;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
		Storage::disk('public')->put($path, $pdfContent);
	 }
}
