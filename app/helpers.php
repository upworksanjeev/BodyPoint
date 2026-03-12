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

if (!function_exists('filterMsrpFaq')) {
    function filterMsrpFaq($faqContent)
    {
        if (empty($faqContent)) return $faqContent;

        /**
         * The Logic:
         * 1. Look for a <p> or <span> tag.
         * 2. Ensure it contains the MSRP phrase.
         * 3. Use [^>]*? to handle any classes/attributes.
         * 4. Use (?!<p) to prevent the regex from jumping across multiple paragraphs.
         */
        $pattern = '/<(p|span)[^>]*>(?:(?!<\/\1>).)*?Where can I find the MSRP\/Retail price.*?<\/\1>/is';

        $filtered = preg_replace($pattern, '', $faqContent);

        // Clean up any double empty paragraphs or trailing spaces left behind
        $filtered = preg_replace('/<p[^>]*>(\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $filtered);
        
        return trim($filtered);
    }
}