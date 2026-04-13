<?php

namespace App\Providers;

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
        // Map Syspro stock list (session) by StockCode for fast lookups in views.
        // This is display-only; if session has no stock list, views will fall back.
        $stockDetails = session('stock_details', []);
        $byCode = [];
        if (is_array($stockDetails)) {
            foreach ($stockDetails as $row) {
                if (!is_array($row)) {
                    continue;
                }
                $code = $row['StockCode'] ?? $row['stockCode'] ?? null;
                if (!$code) {
                    continue;
                }
                $byCode[(string) $code] = $row;
            }
        }
        view()->share('sysproStockByCode', $byCode);
    }
}
