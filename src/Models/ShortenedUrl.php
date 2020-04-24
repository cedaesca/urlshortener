<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2020 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\Models;

use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class ShortenedUrl extends Model
{

    /**
     * Fillable columns for model's mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'created_by',
        'code',
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

    /**
     * Hash the ID to generate an unique code
     * 
     * @return string
     */
    public function generateCode(): string
    {
        $hashids = new Hashids();

        return $hashids->encode($this->id);
    }
}
