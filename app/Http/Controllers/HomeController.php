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


class HomeController extends Controller
{
    /**
     * Display the category details.
     */
    public function index(Request $request)
    {		
	  
        $categories = Category::all();
       		
		if(isset($categories)){
			
			$products = CategoryProduct::with(['product.media'])->get();
			return view('front', array(
				'categories' => $categories,
				'products' => $products,
			));
		}else{
		  return view('front', [
			'error' => 'No Products Found!'
        ]);
		}
    }

    
  
}
