<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\URLShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\URLShortener\Helpers;

use cedaesca\URLShortener\Models\ShortenedUrl;
use cedaesca\URLShortener\Models\Visitor;
use Illuminate\Http\Request;

class URLShortenerHelper
{
    /**
     * Generate an unique code that will serve as an URL parameter
     *
     * @return string
     */
    public function generateCode(): string
    {
        $extraCharacter = '';

        if (config('URLShortener.length') % 2 != 0) {
            $extraCharacter = bin2hex(random_bytes(4));
            $extraCharacter = substr($extraCharacter, -1);
        }

        do {
            $code = bin2hex(random_bytes(config('URLShortener.length') / 2)) . $extraCharacter;
        } while (ShortenedUrl::where('shortlink', $code)->exists());

        return $code;        
    }

    /**
     * Check if there are records for the specified column with the given value
     *
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    public function redirect(Request $request) 
    {
        $record = ShortenedUrl::where('shortlink', $request->shortlink)->first();

        if (is_null($record)) {
            return redirect(config('URLShortener.defaultRedirect'));
        }

        $this->log($request, $record);
        return redirect($record->target);
    }

    /**
     * Create a new shortened URL
     *
     * @param Illuminate\Http\Request $request;
     * @return cedaesca\URLShortener\Models\ShortenedUrl|boolean;
     */
    public function create(Request $request) 
    {
        $data = [
            'shortlink' => $this->generateCode(),
            'target' => $request->target,
            'title' => $request->title,
            'description' => $request->description
        ];

        if ($shortenedUrl = ShortenedUrl::create($data)) {
            return $shortenedUrl;
        }

        return false;
    }

    /**
     * Update Shortened URL's title and description
     *
     * @param Illuminate\Http\Request;
     * @return cedaesca\URLShortener\Models\ShortenedUrl|boolean;
     */
    public function update(Request $request) 
    {
        $shortenedUrl = ShortenedUrl::where('id', $request->id);
        $shortenedUrl->title = $request->title;
        $shortenedUrl->description = $request->description;
        
        if ($shortenedUrl->save()) {
            return $shortenedUrl;
        }

        return false;
    }

    /**
     * Logs the clicks on every shortened URL's
     *
     * @param Illuminate\Http\Request;
     * @param cedaesca\URLShortener\Models\ShortenedUrl
     * @return cedaesca\URLShortener\Models\Visitor|boolean;
     */
    public function log(Request $request, ShortenedUrl $shortenedUrl)
    {
        $data = [
            'agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'shortenedurl_id' => $shortenedUrl->id
        ];

        if ($visitor = Visitor::create($data)) {
            return $visitor;
        }

        return false;
    }
}