<?php

namespace cedaesca\URLShortener\Facades;

use cedaesca\URLShortener\Models\ShortenedUrl;
use Illuminate\Http\Request;

class URLShortener {

    /**
     * URL's code length
     *
     * @var int
     */
    
    public $length = 4;

    /**
     * If the code doesn't exist, it redirects to this default
     *
     * @var string
     */

    public $defaultRedirect = '/';

    /**
     * Genearet an unique code that will serve as an URL parameter
     *
     * @return string
     */

    public function generateCode() {

        $extraCharacter = '';

        if( $this->length % 2 != 0 ) {

            $extraCharacter = bin2hex( random_bytes( 4 ) );
            $extraCharacter = substr( $extraCharacter, -1 );

        }

        do {

            $code = bin2hex( random_bytes( $this->length / 2 ) ) . $extraCharacter;

        } while( $this->checkIfCodeExists( 'shortlink', $code ) );

        return $code;
        
    }

    /**
     * Check if there are records for the specified column with the given value
     *
     * @param string $code
     * @return object
     */

    static function redirect($code) {
        
        $collection = ShortenedUrl::where('shortlink', $code)->first();

        if( ! is_null( $collection ) ) {

            return redirect($collection->target);

        }

        return redirect($this->defaultRedirect);

    }

     /**
     * Check if there are records for the specified column with the given value
     *
     * @param string $type
     * @param string|int $value
     * @return boolean
     */

    public function checkIfCodeExists($type, $value) {

        $collection = ShortenedUrl::where($type, $value)->first();

        if( !is_null( $collection ) ) {

            return true;

        }

        return false;

    }

    /**
     * Create a new shortened URL
     *
     * @param Illuminate\Http\Request;
     * @return cedaesca\URLShortener\Models\ShortenedUrl|boolean;
     */

    static function create(Request $request) {

        $object = new URLShortener;

        $shortenedUrl = ShortenedUrl::create([

            'shortlink' => $object->generateCode(),
            'target' => $request->target,
            'title' => $request->title,
            'description' => $request->description

        ]);

        if( $shortenedUrl->id ) {

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

    static function update(Request $request) {

        $shortenedUrl = ShortenedUrl::where('id', $request->id);
        $shortenedUrl->title = $request->title;
        $shortenedUrl->description = $request->description;
        
        if( $shortenedUrl->save() ) {

            return $shortenedUrl;

        }

        return false;

    }

}