<?php

namespace cedaesca\URLShortener\config;

return [

    /*
    |--------------------------------------------------------------------------
    | URL's code length
    |--------------------------------------------------------------------------
    |
    | Determine the preferred code length for your shortened urls.
    |
    */

    'length' => 4,

    /*
    |--------------------------------------------------------------------------
    | Redirect's default URL
    |--------------------------------------------------------------------------
    |
    | If the code given as argument does not exist, the redirect method will
    | load this route. Default: home
    |
    */

    'defaultRedirect' => '/'
];