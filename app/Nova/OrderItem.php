<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;

class OrderItem extends Resource
{
    public static $model = \App\Models\OrderItem::class;
    public static $with = ['product'];
    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->isSuperAdmin())
            return $query;
        else
            return $query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            });
    }
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hidden(),
            Text::make('Product Name', 'product.name')->sortable(),
            Text::make('Stock Code', 'sku')->sortable(),
            Text::make('Marked For', 'marked_for')->sortable(),
            Text::make('Qty.', 'quantity')->sortable(),
            Text::make('Net Price', 'discount_price')->sortable(),
            Text::make('Unit')->sortable()->resolveUsing(function ($value) {
                return $value ?: 'EA';
            }),
            Text::make('Total', function () {
                return number_format($this->discount_price * $this->quantity, 3, '.', ',');
            })->readonly(),
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
    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    /**
     * Determine if the resource can be updated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }
    public function authorizedToDelete(Request $request)
    {
        return false;
    }
}
