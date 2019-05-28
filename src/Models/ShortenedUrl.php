<?php

namespace cedaesca\URLShortener\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function generateCode() {

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
    
}
