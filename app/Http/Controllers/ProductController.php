<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;



class ProductController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name,Request $request)
    {		
	  
        $categories = Category::all();
        $product = Product::with(['media'])->where('name',$name)->first();
		
		if(isset($product['id'])){
			
			$products = CategoryProduct::with(['category'])->where('product_id',$product['id'])->get();
			
			return view('product', array(
				'categories' => $categories,
				'product' => $product,
				'products' => $products,
			));
			
		}else{
		  return view('product', [
			'error' => 'No product Found!'
        ]);
		}
    }

    
  
}
