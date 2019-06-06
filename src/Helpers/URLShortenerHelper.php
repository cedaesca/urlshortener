<?php

namespace cedaesca\URLShortener\Helpers;

use cedaesca\URLShortener\Models\ShortenedUrl;
use Illuminate\Http\Request;

class URLShortenerHelper
{
    /**
     * Genearet an unique code that will serve as an URL parameter
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
     * @param string $code
     * @return object
     */

    public function redirect($code) 
    {
        $record = ShortenedUrl::where('shortlink', $code)->first();

        if (!is_null($record)) {
            return redirect($record->target);
        }

        return redirect(config('URLShortener.defaultRedirect'));
    }

    /**
     * Create a new shortened URL
     *
     * @param Illuminate\Http\Request $request;
     * @return cedaesca\URLShortener\Models\ShortenedUrl|boolean;
     */

    public function create(Request $request) 
    {
        $object = new URLShortenerHelper;

        $shortenedUrl = ShortenedUrl::create([
            'shortlink' => $object->generateCode(),
            'target' => $request->target,
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($shortenedUrl->id) {
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
}