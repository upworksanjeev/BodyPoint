<?php

return [
    'logo' => '/img/bodypoint.svg',
    'fav' => '/img/bp-favicon-blue.png',
    'home_url' => 'https://bodypoint.com',
    'mail_for_quote' => env('MAIL_FROM_ADDRESS_QUOTE'),
    'mail_for_orders' => env('MAIL_FROM_ADDRESS_ORDERS'),
    'mail_orders_cc' => env('MAIL_ADDRESS_ORDERS_CC'),
    'no_index' => env('NOINDEX', true),
    'quote_lifetime_days' => 90,
    'quote_near_expiry_days' => 14,
    'home_how_to_url' => 'https://www.youtube.com/user/BodypointInc',
];
