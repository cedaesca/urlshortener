![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)

# URL Shortener

Shorten URL's using your own domain

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

```
Laravel 5.8+ (Not tested in previous versions)
```

### Installing

1) Download it into your Laravel app using composer

```
composer require cedaesca/urlshortener
```

2) Publish the packages files
````
php artisan vendor:publish
````

3) Run the migrations.
````
php artisan migrate
````

## Customizing the URL's code length

1) Go to the config file located on `config/cedaesca/URLShortener.php`

2) Change the `length` value for that of your preference.

## URLShortener Facade

You have to add the URLShortener facade to your controller:
````php
use cedaesca\URLShortener\Facades\URLShortener;
````

Then you'll have access to the `create` and `redirect` methods.

## Shorten URL's

Use the `create` static method to shorten a given URL. This method receives the request as argument and returns an instance of the model if was successfully created or false if not:

````php
URLShortener::create($request);
````

## Redirecting users

First off, the redirection route expect a `shortlink` parameter, make sure to name it like that. Later, you can redirect the user to the expected target by returning Laravel's redirect response and giving the returning value of the `target` method as an argument. The `target` method also receives the `\Illuminate\Http\Request` instance.

````php
Route::get('/r/{code}', 'UrlShortenerController@redirect')->name('rthis');
````
````php
return redirect(URLShortener::target($request));
````

## Logging redirected clients

You may want to track some statistics with your shortened URL's. At the moment you can track their user agent, their IP Address and the timestamps. You can decide what to do with that info.

To achieve this, call the log method before the target one in your redirect response. Give the ``\Illuminate\Http\Request` as the argument and now you can leave the `target` argument blank.

````php
return redirect(URLShortener::log($request)->target());
````

## Default redirect

If the code given as argument is invalid, the `redirect` method will redirect the user to a default route. Change this from the config file.

1) Go to the config file located on `config/cedaesca/URLShortener.php`

2) Change the `default_redirect` value for that of your preference.
