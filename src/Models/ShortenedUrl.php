<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2020 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\Models;

use Illuminate\Database\Eloquent\Model;

class ShortenedUrl extends Model
{

    /**
     * Fillable columns for model's mass assignment
     *
     * @var array
     */

    protected $fillable = [
        'created_by',
        'shortlink',
        'target',
        'title',
        'description'
    ];

    /**
     * Custom table for the current model
     *
     * @var string
     */

    protected $table = 'shortenedurls';
}
