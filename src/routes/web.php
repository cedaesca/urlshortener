<?php

Route::get('cedaesca/urlshortener/create', 'cedaesca\URLShortener\Http\UrlShortenerController@create')->name('cedaesca/urlshortener/create');
Route::post('cedaesca/urlshortener/store', 'cedaesca\URLShortener\Http\UrlShortenerController@store')->name('cedaesca/urlshortener/store');
Route::get('r/{code}', 'cedaesca\URLShortener\Http\UrlShortenerController@redirect');