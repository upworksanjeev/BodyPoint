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
use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\URL;
use Laravel\Nova\Fields\Repeater;
use App\Nova\Repeater\VariationAttributeField;


class VariationAttribute extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\VariationAttribute>
     */
    public static $model = \App\Models\VariationAttribute::class;

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
			Select::make('Variation','variation_id')->options(\App\Models\Variation::where('id', $request->viaResourceId)->pluck('name', 'id'))->default($request->viaResourceId)->hideFromIndex()->hideFromDetail(),
            /*Repeater::make('Attributes','product_attribute_id')
                 ->repeatables([
                     VariationAttributeField::make(),
                 ])->asHasMany(),*/
            Select::make('Attribute', 'product_attribute_id')
            ->options(\App\Models\Attribute::leftJoin('product_attributes', 'attributes.id', '=', 'product_attributes.attr_id')
            ->leftJoin('variations', 'variations.product_id', '=', 'product_attributes.prod_id')
            ->where('variations.id', $request->viaResourceId)
            ->pluck('attributes.attribute', 'product_attributes.id'))
            ->hideFromIndex()->hideFromDetail(),
			
			BelongsTo::make('Attribute','attribute', \App\Nova\Attribute::class)->showOnIndex()->sortable()->hideWhenCreating()->hideWhenUpdating(),
		   

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
