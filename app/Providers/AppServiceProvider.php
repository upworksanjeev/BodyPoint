<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->share('partnerPageURl', env('PARTNER_PAGE_URL', 'https://bodypoint.com/find-a-partner-internationa'));
    }
}
