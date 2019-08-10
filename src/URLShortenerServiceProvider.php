<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener;

use Illuminate\Support\ServiceProvider;
use cedaesca\URLShortener\Services\UrlShortenerService;

class UrlShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('UrlShortenerService', function () {
            return new UrlShortenerService;
        });
        
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'UrlShortener');
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('UrlShortener.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/database/Migrations');
    }
}
