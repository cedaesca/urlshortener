<?php

namespace cedaesca\URLShortener;

use Illuminate\Support\ServiceProvider;
use cedaesca\URLShortener\Helpers\URLShortenerHelper;

class URLShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('URLShortener', function () {
            return new URLShortenerHelper;
        });
        
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'URLShortener');
    }
    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('URLShortener.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/database/Migrations');
    }
}
