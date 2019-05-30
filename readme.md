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

2) Run the migrations.

## Customizing the URL's code length

Go to `vendor\cedaesca\urlshortener\src\Facades\URLShortener.php` and change `public $length;` to the lenght that you want. Default value: `4`.

### URLShortener Facade

You have to add the URLShortener facade to your controller:
`use cedaesca\URLShortener\Facades\URLShortener;`

Then you'll have access to the `create` and `redirect` methods.

### Shorten URL's

Use the `create` static method to shorten a given URL. This method receives the request as argument and returns an instance of the model if was successfully created or false if not.

`URLShortener::create(Request $request);`

### Redirecting users

Use the `redirect`static method to redirect users to the target url's. This method receives the URL code parameter as argument.

`Route::get('/r/{code}', 'UrlShortenerController@redirect')->name('rthis');`

`return URLShortener::redirect($code);`