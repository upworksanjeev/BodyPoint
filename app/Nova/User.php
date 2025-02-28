<?php

namespace App\Nova;

use App\Services\SysproService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\HasMany;
use Illuminate\Validation\Rule;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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
        'id',
        'name',
        'email',
    ];

    public static $with = ['getUserDetails','associateCustomers'];

    public static function indexQuery(NovaRequest $request, $query)
    {
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

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                // ->creationRules('unique:users,email')
                // ->updateRules('unique:users,email,{{resourceId}}'),
                ->creationRules([
                    Rule::unique('users', 'email')->whereNull('deleted_at'), 
                ])
                ->updateRules([
                    Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($this->resource->id),
                ]),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
            
            
            Password::make('Confirm Password')
            ->onlyOnForms()
            ->rules('required_with:password', function ($attribute, $value, $fail) use ($request) {
                if ($request->password !== $value) {
                    $fail('The Confirm Password must match the Password.');
                }
            })
            ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                // Avoid saving in DB
            }),

            Select::make('Role')
                ->options(function () {
                    return \Spatie\Permission\Models\Role::where('name', '<>', 'super-admin')->pluck('name')->mapWithKeys(function ($value) {
                        return [$value => $value];
                    });
                })
                ->fillUsing(function ($request, $model, $attribute) {
                    // After the user is saved, syncRoles will be called with the selected role(s)
                    $model::saved(function ($model) use ($request, $attribute) {
                        $roles = $request->{$attribute};
                        if (is_array($roles)) {
                            $model->syncRoles($roles); // synchronize roles
                        } else {
                            $model->syncRoles([$roles]); // if only one role is selected, wrap it in an array
                        }
                    });
                })->hideFromIndex()->resolveUsing(function ($request, $model) {
                    return $model->getRoleNames();
                })->rules('required')->canSee(
                    function ($request) {
                        return ($request->user()->isAdmin());
                    }
                ),

                Text::make('Customer Number', 'default_customer_id')
                ->hideFromIndex()
                ->rules('required', 'max:255')
                //->creationRules('unique:users,default_customer_id')
                //->updateRules('unique:users,default_customer_id,{{resourceId}}')
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    $customerId = $request->{$attribute};
            
                    $url = 'GetCustomerDetails/' . $customerId;
                    $get_customer_details = SysproService::getCustomerDetails($url);
                    if (!$get_customer_details) {
                        throw ValidationException::withMessages([
                            $attribute => 'Customer Number not found.',
                        ]);
                    }
            
                    $model->{$attribute} = $customerId;
                }),

            Text::make('Payment Term Description', 'payment_term_description')
                ->readonly()
                ->hideFromIndex()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            HasMany::make('Associated Customers', 'associateCustomers', AssociateCustomer::class),

            MorphToMany::make('Roles', 'roles', \Sereny\NovaPermissions\Nova\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Sereny\NovaPermissions\Nova\Permission::class),

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
