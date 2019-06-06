<?php

namespace cedaesca\URLShortener\Facades;

use Illuminate\Support\Facades\Facade;

class URLShortenerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'URLShortenerHelper';
    }
}