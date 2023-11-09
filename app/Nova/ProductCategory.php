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
use Laravel\Nova\Fields\Text;


class ProductCategory extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ProductCategory>
     */
    public static $model = \App\Models\ProductCategory::class;

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
			Select::make('Product','prod_id')->searchable()->options(\App\Models\Product::where('id', $request->viaResourceId)->pluck('name', 'id'))->hideFromIndex()->hideFromDetail(),
			select::make('Category','cat_id')->options(\App\Models\Category::pluck('name', 'id'))->hideFromIndex()->hideFromDetail(),
			//Text::make('ID')->default(\App\Models\Product::where('id', $request->viaResourceId)->pluck('name'))->hideWhenCreating()->hideWhenUpdating(),		
				/*BelongsTo::make('Category','category', \App\Nova\ProductCategory::class),
				BelongsTo::make('Product','product', \App\Nova\ProductCategory::class),*/
			
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
