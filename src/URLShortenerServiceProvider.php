<?php

namespace cedaesca\URLShortener;

use Illuminate\Support\ServiceProvider;

class URLShortenerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/URLShortener.php', 'URLShortener');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/URLShortener.php' => config_path('URLShortener.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/database/Migrations');
    }
}
