<?php

if (!function_exists('getCustomerId')) {
    function getCustomerId()
    {
        $customer_id = session()->get('customer_id') ? session()->get('customer_id') : auth()->user()->default_customer_id;
        return $customer_id;
    }
}
