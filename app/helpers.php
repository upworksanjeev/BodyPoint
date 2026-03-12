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
    function filterMsrpFaq($html)
    {
        if (empty($html)) return $html;

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        
        // Wrap in div and convert encoding
        $dom->loadHTML(mb_convert_encoding('<div>' . $html . '</div>', 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new \DOMXPath($dom);

        // Search for the specific question
        $question = "Where can I find the MSRP/Retail price for this product?";
        
        // Use normalize-space() to ignore extra &nbsp; or random spaces inside the tag
        $nodes = $xpath->query("//*[contains(normalize-space(.), '$question')]");

        foreach ($nodes as $node) {
            $container = $node;
            // Traverse up to find the main container (<p> or <span>) inside our <div>
            while ($container->parentNode && $container->parentNode->nodeName !== 'div') {
                $container = $container->parentNode;
            }
            
            if ($container->parentNode) {
                $container->parentNode->removeChild($container);
            }
        }

        // Convert back to string
        $output = $dom->saveHTML();
        $output = str_replace(['<div>', '</div>'], '', $output);

        /**
         * SMART CLEANUP FOR MIDDLE CONTENT
         */
        
        // 1. Remove paragraphs that contain ONLY non-breaking spaces or BR tags
        // This removes the "empty" lines often left by editors between questions
        $output = preg_replace('/<p[^>]*>(\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $output);

        // 2. Fix "Triple Spacing"
        // If removing the item created too much white space, collapse it.
        // This converts 3+ newlines into just 2.
        $output = preg_replace('/(\r?\n\s*){3,}/', "\n\n", $output);

        return trim($output);
    }
}