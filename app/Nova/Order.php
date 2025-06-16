<?php

namespace App\Nova;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\HasMany;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\Order::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id'
    ];
    public static $with = ['user', 'customer'];
    public static $clickAction = 'view';
    public static function indexQuery(NovaRequest $request, $query)
    {
        $query = $query->where('status', '!=', 'F');
        if ($request->user()->isSuperAdmin())
            return $query;
        else
            return $query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            });
    }

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
            Text::make('Sales Order Number.', 'purchase_order_no')->sortable()->readonly(),
            Text::make('Customer PO Number', 'customer_po_number')->sortable()->readonly(),
            Text::make('Total Items', 'total_items')->sortable()->readonly(),
            Text::make('Status', 'order_status')->sortable()->readonly(),
            Text::make('Total', 'total')->sortable()->readonly(),
            Text::make('Customer Number', 'customer_number')->readonly()->hideFromIndex(),
            Text::make('Customer Name', function () {
                return $this->customer ? $this->customer->name : ($this->user ? $this->user->name : null);
            })->readonly()->hideFromIndex(),
            Text::make('Date', function () {
                return Carbon::parse($this->created_at)->format('d-m-Y h:i A');
            })->readonly()->hideFromIndex(),

            HasMany::make('Products', 'orderItem', OrderItem::class),
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
    public function authorizedToUpdate(Request $request)
    {
        return false;
    }
}
