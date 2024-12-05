<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use App\Nova\CategoryProduct;
use App\Nova\User;
use App\Nova\Category;
use App\Nova\Product;
use App\Nova\ProductAttribute;
use App\Nova\AttributeCategory;
use App\Nova\Attribute;
use Sereny\NovaPermissions\Nova\Role;
use Sereny\NovaPermissions\Nova\Permission;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Blade;
use App\Models\Product as ProductModel;
use App\Models\ProductAttribute as ProductAttributeModel;
use App\Nova\Order;
use App\Nova\Quote;
use Laravel\Nova\Observable;
use App\Observers\ProductObserver;
use App\Observers\ProductAttributeObserver;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        parent::boot();

        Nova::initialPath('/resources/users');

        //Observable::make(ProductModel::class, ProductObserver::class);
        //Observable::make(ProductAttributeModel::class, ProductAttributeObserver::class);
        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::make('Users', [
                    MenuItem::resource(User::class),
                ])->icon('user-group')->collapsable(),

                MenuSection::make('Roles & Permissions', [
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Permission::class)
                ])->icon('shield-check')->collapsable()->canSee(function (NovaRequest $request) {
                    return $request->user()->isSuperAdmin();
                }),

                MenuSection::make('Ecommerce', [
                    MenuItem::resource(Product::class),
                    MenuItem::resource(Category::class),
                    MenuItem::resource(AttributeCategory::class),
                    MenuItem::resource(Attribute::class),
                ])->icon('list')->collapsable(),

                MenuSection::make('Orders', [
                    MenuItem::resource(Order::class),
                ])->icon('list')->collapsable(),

                MenuSection::make('Quotes', [
                    MenuItem::resource(Quote::class),
                ])
                ->icon('list')
                ->collapsable(),
            ];
        });

        Nova::userMenu(function (Request $request, Menu $menu) {
            $menu->prepend(
                MenuItem::make(
                    'My Profile',
                    "/resources/users/{$request->user()->getKey()}"
                )
            );

            return $menu;
        });

        Nova::footer(function ($request) {
            return Blade::render('<p align="center">&#169; 2023. Bodypoint</p>');
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return $user->is_admin;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new \Sereny\NovaPermissions\NovaPermissions(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
