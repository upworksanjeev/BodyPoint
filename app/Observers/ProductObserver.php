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
			$attributes['cat_id']=8;
			$this->product_id = $model->id;
			$this->product_id = $request->id;
			$attributes['prod_id']=$this->product_id;
			$abc = new ProductCategory($attributes);
			$abc->save();
		
        }, function (Request $request) use ($model) {
            // Invoked for non-Nova requests...
        });

        // Always invoked...
    }
}