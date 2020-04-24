<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\config;

return [

    /*
    |--------------------------------------------------------------------------
    | URL's code length
    |--------------------------------------------------------------------------
    |
    | Determine the preferred code length for your shortened urls.
    |
    */

    'code_length' => 4,

    /*
    |--------------------------------------------------------------------------
    | Redirect's default URL
    |--------------------------------------------------------------------------
    |
    | If the code given as argument does not exist, the redirect method will
    | load this route. Default: home
    |
    */

    'default_redirect' => 'https://anydomain.example'
];
