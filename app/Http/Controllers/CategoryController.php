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
use Illuminate\Contracts\Database\Eloquent\Builder;


class CategoryController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name,Request $request)
    {		
	    $name=ucwords(str_replace('-',' ',$name));
        $categories = Category::all();
        $category = Category::where('name',$name)->first();
		
		if(isset($category['id'])){
			
			$products = CategoryProduct::with(['product.media'])->where('category_id',$category['id'])->get();
			return view('category', array(
				'categories' => $categories,
				'category' => $category,
				'products' => $products,
			));
		}else{
		  return view('category', [
			'error' => 'No Category Found!'
        ]);
		}
    }

    
  
}
