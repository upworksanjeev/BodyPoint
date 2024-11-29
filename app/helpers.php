<?php

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
