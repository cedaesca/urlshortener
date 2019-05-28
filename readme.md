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

2) Run the migrations so we can store our shortened url's.

```
php artisan migrate
```

## Customizing the URL's code length

Go to `vendor\cedaesca\urlshortener\src\models\ShortenedUrl.php` and change `public $length = 4;` to the lenght that you want.

## Creating a short URL

We are gonna use our `store` method for this. The only required field is the target URL, the other ones are optionals.
You can store: `title` and `description` too. Our controller's method use an instance of the `ShortenedUrl` model and uses the method `generateCode` to generate an unique code and store all the data. The `store` method returns a json object with all the shortened url information.