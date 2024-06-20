<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Media;



class HomeController extends Controller
{
	/**
	 * Display the category details.
	 */
	public function index(Request $request)
	{
		$categories = Category::all();
		if (isset($categories)) {
			$products = CategoryProduct::select('product_id')
				->groupBy('product_id')
				->with(['product.media'])
				->paginate(16);
			
			return view('front', [
				'categories' => $categories,
				'products' => $products,
			]);
		} else {
			return view('front', [
				'error' => 'No Products Found!'
			]);
		}
	}
}
