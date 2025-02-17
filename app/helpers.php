<?php

use Illuminate\Support\Facades\Auth;


$APP_URL = env('APP_URL');
$WP_URL = env('WP_URL');


if (!function_exists('getCustomerId')) {
    function getCustomerId()
    {
        $customer_id = session()->get('customer_id') ? session()->get('customer_id') : auth()->user()->default_customer_id;
        return $customer_id;
    }
}

if (!function_exists('getCustomerClass')) {
    function getCustomerClass()
    {
        $customer_class = session()->get('customer_details') ? session()->get('customer_details')['CustomerClass'] : "";
        return $customer_class;
    }
}


if (!function_exists('clearSession')) {
    function clearSession()
    {
        session()->forget('downloadFile');
    }
}

if (!function_exists('getCustomer')) {
    function getCustomer()
    {
        $customer_id = session()->get('customer_id') ?? auth()->id();
        
        // Check if the user is authenticated before calling load()
        if (Auth::check()) {
            $user = Auth::user()->load(['associateCustomers', 'roles.permissions']);
            $customer = $user->associateCustomers()->where('customer_id', $customer_id)->first();
            return $customer ?? $user;
        }

        return null; // Return null if no authenticated user
    }
}

if (!function_exists('calculateDiscountPercentage')) {
    function calculateDiscountPercentage($msrp, $dealerPrice)
    {
        if ($msrp <= 0) {
            return 0;
        }
        $discountPercentage = (($msrp - $dealerPrice) / $msrp) * 100;
        return round($discountPercentage, 2);
    }
}
