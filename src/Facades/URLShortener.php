<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\Facades;

use Illuminate\Support\Facades\Facade;

class UrlShortener extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'UrlShortener';
    }
}
