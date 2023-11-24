<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\StorePostRequest; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\ProductMedia;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;
use App\Models\Country;
use App\Models\UserDetails;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name,Request $request)
    {		
	  
        $categories = Category::all()->toArray();
        $category = Category::where('name',$name)->get()->toArray();
		
		if(count($category)>0){
			$products = Product::leftJoin('category_product', 'product_id', '=', 'products.id')->leftJoin('media', 'model_id', '=', 'products.id')->where('category_id',$category[0]['id'])->select('products.id as product_id','products.*','file_name','media.id as media_id')->get()->toArray();
			
			return view('category', array(
				'user' => $request->user(),
				'categories' => $categories,
				'category' => $category,
				'products' => $products,
			));
		}else{
		  return view('category', [
            'user' => $request->user(),
			'error' => 'No Category Found!'
        ]);
		}
    }

    
  
}
