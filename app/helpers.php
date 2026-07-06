<?php

use Illuminate\Support\Facades\Auth;

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

if (!function_exists('emergencyModeMessage')) {
    function emergencyModeMessage(): string
    {
        $default = 'Online ordering is temporarily paused while we resolve a technical issue. To place an order, please email sales@bodypoint.com or call 1-800-547-5716. Thank you for your patience.';

        try {
            $setting = \App\Models\EmergencyModeSetting::query()->first();
            if (!$setting) {
                return $default;
            }

            return trim((string) $setting->banner_message) !== '' ? $setting->banner_message : $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }
}