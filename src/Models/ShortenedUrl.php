<?php

namespace cedaesca\URLShortener\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ShortenedUrl extends Model
{

    /**
     * Fillable columns for model's mass assignment
     *
     * @var array
     */
    
    protected $fillable = [
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
