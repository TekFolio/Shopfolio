<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Shopfolio Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify which authentication guard Shopfolio will use while
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Login username
    |--------------------------------------------------------------------------
    |
    | This value defines which model attribute should be considered as your
    | application's "username" field. Typically, this might be the email
    | address of the users but you are free to change this value here.
    |
    */

    'username' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Two Factor Authentication
    |--------------------------------------------------------------------------
    |
    | Enabled 2FA authentication during login on the shopfolio dashboard.
    |
    */

    '2fa_enabled' => env('SHOPFOLIO_ENABLED_TWO_FACTOR', true),

];
