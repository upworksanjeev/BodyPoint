<?php

return [
    'logo' => '/img/bodypoint.svg',
    'fav' => '/img/bp-favicon-blue.png',
    'home_url' => 'https://bodypoint.com',
    'mail_for_quote' => env('MAIL_FROM_ADDRESS_QUOTE'),
    'mail_for_orders' => env('MAIL_FROM_ADDRESS_ORDERS'),
    'mail_for_emergency' => array_values(array_filter(array_map('trim', explode(',', (string) env('MAIL_FROM_ADDRESS_EMERGENCY'))))),
    'mail_orders_cc' => env('MAIL_ADDRESS_ORDERS_CC'),
    'no_index' => env('NOINDEX', true),
];
