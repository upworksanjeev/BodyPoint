<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;

class AssociateCustomer extends Resource
{

    
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\AssociateCustomer>
     */
    public static $model = \App\Models\AssociateCustomer::class;

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
        'name',
        'customer_id',
    ];

     /**
     * ✅ Redirect back to the User after saving
     */
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return "/resources/users/{$resource->user_id}";
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return "/resources/users/{$resource->user_id}";
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if ($request->user()->isSuperAdmin())
            return $query;
        else
            return $query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super-admin');
            });
    }

 
    public static function createButtonLabel()
    {
        return 'Attach Associate Customer'; 
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

        Text::make('Syspro Customer ID', 'customer_id')
            ->sortable()
            ->rules([
                'required', 'max:255',
                Rule::unique('associate_customers')->where(function ($query) use ($request) {
                    // Get the `user_id` from the URL when editing a user
                    $userId = $request->viaResourceId ?? $request->resourceId;
                    return $query->where('user_id', $userId);
                })
            ])
            ->help('Syspro Customer ID cannot be empty and must be unique for the user.'),

        Text::make('Customer Name', 'name')
            ->sortable()
            ->rules('required', 'max:255')
            ->help('Customer Name cannot be empty.'), 
        Text::make('First Name', 'first_name')
            ->sortable()
            ->rules('max:255'),

        Text::make('Last Name', 'last_name')
            ->sortable()
            ->rules('max:255'),
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

    public function authorizedToUpdate(Request $request)
    {
        return true;
    }

    public function authorizedToView(Request $request)
    {
        return false;
    }
    public function authorizedToDelete(Request $request)
    {
        return true;
    }

    public static function authorizedToCreate(Request $request)
    {
        return true;
    }
}
