<?php

return [
    /**
     * minates
     */
    'ttl' => 7 * 24 * 60,

    'store_drivers' => [
        'database' => [
            'model' => 'Faza13\Carts\Models\Cart'
        ],
        'redis' => [
            'conn' => 'cart',
        ],
        'cookie' => [
        ],
    ],

    'authed_store' => [
        'driver' => 'redis',
    ],

    'default_store' => [
        'driver' => 'redis',
    ],

    'cart_table' => 'carts',
];