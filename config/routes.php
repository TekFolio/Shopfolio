<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix method can be used for the prefix of each
    | route in the administration panel. For example, you can change to 'admin'.
    |
    */

    'prefix' => env('SHOPFOLIO_DASHBOARD_PREFIX', 'shopfolio'),

    /*
    |--------------------------------------------------------------------------
    | Shopfolio Routes Middleware
    |--------------------------------------------------------------------------
    |
    | Here you may specify which middleware Shopfolio will assign to the routes
    | that it registers with the application. If necessary, you may change
    | these middleware but typically this provided default is preferred.
    |
    */

    'middleware' => [],

    /*
    |--------------------------------------------------------------------------
    | Shopfolio Custom backend route file
    |--------------------------------------------------------------------------
    |
    | This value sets the file to load for Shopfolio admin custom routes. This
    | depend of your application.
    | Eg.: base_path('routes/shopfolio.php')
    |
    */

    'custom_file' => null,
];
