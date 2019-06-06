<?php

namespace cedaesca\URLShortener\Facades;

use Illuminate\Support\Facades\Facade;

class URLShortener extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'URLShortenerHelper';
    }
}