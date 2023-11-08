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
        return [
            ID::make()->sortable(),
			BelongsTo::make('Product', 'product', \App\Nova\Product::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
			
			//BelongsTo::make('Attribute Category', 'attr_cat', \App\Nova\AttributeCategory::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
			BelongsTo::make('Attribute', 'attribute', \App\Nova\Product::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
			
			
			Select::make('Product','prod_id')->searchable()->options(\App\Models\Product::pluck('name', 'id'))->hideFromIndex()->hideFromDetail(),
			Select::make('Attribute Category','attr_cat')->searchable()->options(\App\Models\AttributeCategory::pluck('category', 'id'))->hideFromIndex()->hideFromDetail()->fillUsing(function(NovaRequest $request, $model, $attribute, $requestAttribute) {
                return null;
            }),
			
			BooleanGroup::make('Attribute','attr_id')->dependsOn(
				['attr_cat'],
				function (BooleanGroup $field, NovaRequest $request, FormData $formData) {
					$field->options(\App\Models\Attribute::where('att_cat_id', $formData->attr_cat)->pluck('attribute', 'id'));
				})->hideFromIndex()->hideFromDetail(),
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
