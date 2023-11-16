<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\URL;


class ProductAttribute extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductAttribute>
     */
    public static $model = \App\Models\ProductAttribute::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
		$data=\App\Models\Product::where('id', $request->viaResourceId)->pluck('product_type', 'id');
		if(!isset($request->viaResourceId) || $data[$request->viaResourceId]=="Option"){
        return [
            ID::make()->sortable(),
			Select::make('Product','prod_id')->options(\App\Models\Product::where('id', $request->viaResourceId)->pluck('name', 'id'))->default($request->viaResourceId)->hideFromIndex()->hideFromDetail(),
		
			
			Select::make('Attribute Category','attr_cat')->searchable()->options(\App\Models\AttributeCategory::pluck('category', 'id'))->hideFromIndex()->hideFromDetail()->fillUsing(function(NovaRequest $request, $model, $attribute, $requestAttribute) {
                return null;
            }),
			
		
			Select::make('Attribute','attr_id')->dependsOn(
				['attr_cat'],
				function (Select $field, NovaRequest $request, FormData $formData) {
					$field->options(\App\Models\Attribute::where('att_cat_id', $formData->attr_cat)->pluck('attribute', 'id'));
				})->hideFromIndex()->hideFromDetail(),
				
				
			BelongsTo::make('Product', 'product', \App\Nova\Product::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
			//BelongsTo::make('Attribute Category', 'attributecategory', \App\Nova\AttributeCategory::class)->sortable()->hideWhenCreating()->hideWhenUpdating(),
			BelongsTo::make('Attribute', 'attribute', \App\Nova\Attribute::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
		    

        ];
		}else{
			
			return [

			Text::make("Message")->default("This Product is not Option Type, So products don't have any attributes!")->readonly()->hideFromIndex()->hideFromDetail()->fillUsing(function(NovaRequest $request, $model, $attribute, $requestAttribute) {
                return null;
            }),
			];
		}
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [ ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
