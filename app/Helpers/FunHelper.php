<?php
namespace App\Helpers;
use App\Models\Category;
use App\Models\Cart;
use Auth;

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
}