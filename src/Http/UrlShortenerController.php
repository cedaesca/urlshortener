<?php

namespace cedaesca\URLShortener\Http;

use Illuminate\Http\Request;
use cedaesca\URLShortener\Models\ShortenedUrl;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

class UrlShortenerController extends Controller
{
    public function create() {

        return view('URLShortener::url.create');

    }

    /**
     * Store a new record in the shortenedurls table
     *
     * @param Illuminate\Http\Request
     * @return json
     */

    public function store(Request $request) {

        $validatedData = $request->validate([

            'target' => 'required|max:255'

        ]);

        $shortenedUrl = new ShortenedUrl;

        $shortenedUrl = $shortenedUrl::create([

            'shortlink' => $shortenedUrl->generateCode(),
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
     * @param string $code
     * @return object
     */

    public function redirect($code) {

        $shortenedUrl = new ShortenedUrl;
        
        $collection = ShortenedUrl::where('shortlink', $code)->first();

        if( ! is_null( $collection ) ) {

            return redirect($collection->target);

        }

        return redirect($shortenedUrl->defaultRedirect);

    }
}
