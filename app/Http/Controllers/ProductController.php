<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\AttributeCategory;
use App\Models\Media;



class ProductController extends Controller
{
    /**
     * Display the category details.
     */
    public function index($name,Request $request)
    {		
		 if(str_contains($name,'-r-')){
			 $name=str_replace('-r-','®-',$name);
		 }
		 if(str_contains($name,'-tm-')){
			 $name=str_replace('-tm-','™-',$name);
		 }
	   $name=ucwords(str_replace('_','-',str_replace('-',' ',$name)));
	  
        $categories = Category::all();
        $product = Product::with(['media'])->where('name',$name)->first();
		
		if(isset($product['id'])){
			
			$products = CategoryProduct::with(['category'])->where('product_id',$product['id'])->get();
			$productattr = AttributeCategory::select(				
					'category',
					'attribute',
				)
				->leftjoin('attributes', 'attribute_categories.id', '=', 'att_cat_id')
				->leftjoin('product_attributes', 'attributes.id', '=', 'attr_id')
				->where('prod_id', $product['id'])->orderby('category')->get();
				$i=0;
				$category=[];
				$attribute=[];
			/* attributes and their categories name for this product */
			foreach($productattr as $k => $v){
				if(in_array($v['category'],$category)){
					$key = array_search($v['category'],$category); 
					$attribute[$key][]=$v['attribute'];
				}else{
					$category[$i]=$v['category'];
					$attribute[$i][]=$v['attribute'];
					$i++;
				}
				
			}
			return view('product', array(
				'categories' => $categories,
				'category' => $category,
				'attribute' => $attribute,
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
