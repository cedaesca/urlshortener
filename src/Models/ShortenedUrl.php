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

    static function generateCode() {

        $extraCharacter = '';

        if( $this->length % 2 != 0 ) {

            $extraCharacter = bin2hex( random_bytes(4) );
            $extraCharacter = substr( $extraCharacter, -1 );

        }

        do {

            $code = bin2hex( random_bytes( $this->length / 2 ) ) . $extraCharacter;

        } while( $this->checkIfExists('shortlink', $code) );

        return $code;
        
    }

    /**
     * Store a new record in the shortenedurls table
     *
     * @param Illuminate\Http\Request
     * @return json
     */

    public function shortLink(Request $request) {

        $validatedData = $request->validate([

            'target' => 'required|max:255'

        ]);

        $shortenedUrl = $this::create([

            'shortlink' => $this::generateCode(),
            'target' => $request->target,
            'title' => $request->title,
            'description' => $request->description

        ]);

        if( $shortenedUrl->id ) {

            return response()->json([
                'message' => 'Created successfully',
                'data' => [
                    'id' => $shortenedUrl->id,
                    'shortenedlink' => $shortenedUrl->shortlink,
                    'title' => $shortenedUrl->title,
                    'description' => $shortenedUrl->description,
                    'created_at' => $shortenedUrl->created_at,
                    'target' => $shortenedUrl->target
                ]
            ], 201);

        }

        return response()->json([
            'message' => 'Occured an error while trying to create a shortened URL, try again'
        ], 400);

    }

    /**
     * Check if there are records for the specified column with the given value
     *
     * @param string $type
     * @param string|int $value
     * @return boolean
     */

    public function checkIfExists($type, $value) {

        $collection = $this::where($type, $value)->first();

        if( !is_null( $collection ) ) {

            return true;

        }

        return false;

    }

    /**
     * Check if there are records for the specified column with the given value
     *
     * @param string $code
     * @return object
     */

    public function redirect($code) {
        
        $collection = $this::where('shortlink', $code)->first();

        if( ! is_null( $collection ) ) {

            return redirect($collection->target);

        }

        return redirect($this->defaultRedirect);

    }
    
}
