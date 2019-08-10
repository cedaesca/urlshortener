<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\URLShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\URLShortener\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /**
     * Fillable columns for model's mass assignment
     *
     * @var array
     */
    
    protected $fillable = [
        'agent',
        'ip',
        'shortenedurl_id'
    ];

    /**
     * Custom table for the current model
     *
     * @var string
     */

    protected $table = 'visitors';
}
