<?php

return [
    /**
     * minates
     */
    'ttl' => 7 * 24 * 60,

    'store_drivers' => [
        'database' => [
            'model' => '\Faza13\Cart\Models\Cart'
        ],
        'redis' => [
            'conn' => 'default',
        ],
        'cookie' => [
        ],
    ],

    'authed_store' => [
        'driver' => 'redis',
    ],

    'default_store' => [
        'driver' => 'database',
    ],

    'cart_table' => 'carts',
];
