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
	  
        $categories = Category::all();
        $category = Category::where('name',$name)->get();
		
		if(count($category)>0){
			
			$products = CategoryProduct::with(['product.media'])->where('category_id',$category[0]['id'])->get();
			/*echo "<pre>";
			foreach($products as $prodcat){
				echo($prodcat['product']['name']);
				echo $prodcat['product']['media'][0]['file_name'] ?? $prodcat['product']['media'][0]['file_name'];
			}
			die;*/
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
