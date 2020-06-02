<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    |
    */
    'guards' => [
        'client-logins' => [
            'driver' => 'jwt',
            'provider' => 'clients',
            'hash' => false,
        ],
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */
    'providers' => [
        'clients' => [
            'driver' => 'eloquent',
            'model' => Techneved\Client\Models\Client::class,
        ],
    ],

    'passwords' => [
        'clients' => [
            'provider' => 'clients',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],

];