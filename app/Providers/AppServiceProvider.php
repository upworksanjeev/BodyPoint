<?php

namespace App\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\SysproService;
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
         // Redirect users if email is not verified
         view()->composer('*', function ($view) {
            if (Auth::check() && is_null(Auth::user()->email_verified_at)) {
                Redirect::to(route('verification.notice'))->send();
            }
        });
    }
}
