<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\StorePostRequest;
use App\Services\SysproService;
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
        $categories = Category::where('parent_cat_id',0)->get();
        $category = Category::where('name',$name)->first();

        if (!empty(auth()->user()->default_customer_id)) {
            $url = 'ListStock';
            SysproService::listStock($url);
        }

		if(isset($category['id'])){
			$cat[]=$category['id'];
			$subcategory = Category::where('parent_cat_id',$category['id'])->select('id','name')->get();
			if(count($subcategory) > 0){
				foreach($subcategory as $k=>$v){
					$cat[]=$v['id'];
				}
			}
			$products = CategoryProduct::with(['product.media'])->whereIn('category_id',$cat)->paginate(16);

			return view('category', array(
				'categories' => $categories,
				'subcategory' => $subcategory,
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
