<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Repeater;
use App\Nova\Repeater\VariationAttributeField;


class Variation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Variation>
     */
    public static $model = \App\Models\Variation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','sku','name'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
		
		$data=\App\Models\Product::leftJoin('variations', 'variations.product_id', '=', 'products.id')->where('variations.id', $request->id)->select('products.name as pname', 'products.id as pid')->first();
		$product_id=$data->pid??'';
		$product_name=$data->pname??'';
        return [
            ID::make()->sortable(),
			Text::make('Variation Name','name'),
			Text::make('SKU','sku')->sortable()->maxlength(255),
            Number::make('MSRP','msrp')->min(1)->max(999999)->step(0.01)->sortable()->hideFromIndex(),
			Number::make('Price','price')->min(1)->max(999999)->step(0.01)->sortable(),
			Number::make('Discount (in %)','discount')->min(1)->max(100)->step('any')->hideFromIndex(),		
			
			HasMany::make('Variation Attributes','variationAttribute',\App\Nova\VariationAttribute::class)->hideWhenCreating(),


				
        ];
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
        return [];
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
