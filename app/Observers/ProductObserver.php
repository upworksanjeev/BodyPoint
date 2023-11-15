<?php 

namespace App\Observers;

use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use App\Models\ProductCategory;


class ProductObserver
{
	public $product_id;
	public function saving(Product $model): void
    {
        Nova::whenServing(function (NovaRequest $request) use ($model) {
        });
    }
	
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
   public function saved(Product $model)
    {
        Nova::whenServing(function (NovaRequest $request) use ($model) {
            // Only invoked during Nova requests...
			
			//$arr=Product::where('name', $request->name)->where('small_description', $request->small_description)->where('sizing', $request->sizing)->where('product_type', $request->product_type)->pluck('name', 'id');
			/*$id=Product::where('name', $request->name)->where('small_description', $request->small_description)->where('sizing', $request->sizing)->where('product_type', $request->product_type)->pluck('id');
			

			
			$attributes['prod_id']=1;
			$attributes['cat_id']=8;
			$abc = new ProductCategory($attributes);
			$abc->save();*/
		
        }, function (Request $request) use ($model) {
            // Invoked for non-Nova requests...
        });

        // Always invoked...
    }
}