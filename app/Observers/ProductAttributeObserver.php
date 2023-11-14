<?php 

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Nova;
use App\Models\ProductCategory;
use App\Models\AttributeCategory;
use App\Models\Attribute;


class ProductAttributeObserver
{
	
	public function saving(ProductAttribute $model): void
    {
        Nova::whenServing(function (NovaRequest $request) use ($model) {
			$arr=json_decode($request->input('attr_id'));
			foreach($arr as $k => $v){
				if($v==true){
					$model->prod_id = $request->input('prod_id');
					$model->attr_id = $k;
					//$model->save();
				}
				
			}
        });
    }
	
    /**
     * Handle the ProductAttribute "created" event.
     *
     * @param  \App\Models\ProductAttribute  $ProductAttribute
     * @return void
     */
   public function saved(ProductAttribute $model)
    {
        Nova::whenServing(function (NovaRequest $request) use ($model) {
            // Only invoked during Nova requests...
		
        }, function (Request $request) use ($model) {
            // Invoked for non-Nova requests...
        });

        // Always invoked...
    }
}