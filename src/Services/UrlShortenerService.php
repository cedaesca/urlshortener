<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2019 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\Services;

use cedaesca\UrlShortener\Models\ShortenedUrl;
use cedaesca\UrlShortener\Models\Visitor;
use Illuminate\Http\Request;

class UrlShortenerService
{
    /**
     * Shortened Url Instance
     * 
     * @var cedaesca\UrlShortener\Models\ShortenedUrl
     */
    protected $shortened_url;

    /**
     * Visitor Instance
     * 
     * @var cedaesca\UrlShortener\Models\Visitor
     */
    protected $visitor;

    /**
     * Request instance
     * 
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Target URL to which the client will be redirected
     * 
     * @var string
     */
    protected $target;

    /**
     * Generate an unique code that will serve as an URL parameter
     *
     * @return string
     */
    private function generateCode(): string
    {
        $extraCharacter = '';

        if (config('UrlShortener.length') % 2 != 0) {
            $extraCharacter = bin2hex(random_bytes(4));
            $extraCharacter = substr($extraCharacter, -1);
        }

        $shortenedUrlSaved = ShortenedUrl::select("shortlink")
            ->pluck('shortlink')
            ->toArray();

        do {
            $code = bin2hex(random_bytes(config('UrlShortener.length') / 2)) . $extraCharacter;
        } while (in_array($code, $shortenedUrlSaved));

        return $code;
    }

    /**
     * Set the property to the shortened url model
     * 
     * @param string $column
     * @param mixed $value
     * @return UrlShortenerService
     */
    public function setShortened($column, $value = null)
    {
        if (is_null($column)) {
            throw new Exception('Invalid column');
        }

        $shortenedUrl = ShortenedUrl::where($column, $value)->first();
        
        if (! is_null($shortenedUrl)) {
            $this->shortened_url = $shortenedUrl;
        }

        return $this;
    }

    /**
     * Return an instance of the shortened url
     * 
     * @return cedaesca\UrlShortener\Models\ShortenedUrl
     */
    public function get()
    {
        return $this->shortened_url;
    }

    /**
     * Check if there are records for the specified column with the given value
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function setTarget(Request $request)
    {
        if (is_null($request)) {
            throw new Exception('Null request');
        }

        if (is_null($this->shortened_url)) {
            $this->setShortened('shortlink', $this->request->shortlink);
        }
        
        $this->target = is_null($this->shortened_url) ? config('UrlShortener.default_redirect') 
            : $this->shortened_url->target;
    }

    /**
     * Return the target URL for the given code
     *
     * @param mixed \Illuminate\Http\Request|null $request
     * @return string
     */
    public function target(Request $request = null)
    {
        if (is_null($this->request)) {
            $this->setRequest($request);
        }

        $this->setTarget($this->request);
        return $this->target;
    }

    /**
     * Create a new shortened URL
     *
     * @param Illuminate\Http\Request $request;
     * @return UrlShortenerService
     */
    public function create(Request $request) 
    {
        $data = [
            'shortlink' => $this->generateCode(),
            'target' => $request->target,
            'title' => $request->title,
            'description' => $request->description
        ];

        $this->shortened_url = ShortenedUrl::create($data);
        return $this;
    }

    /**
     * Update Shortened URL's title and description
     *
     * @param Illuminate\Http\Request;
     * @return UrlShortenerService
     */
    public function update(Request $request) 
    {
        $shortenedUrl = $this->setShortened('id', $request->id)->get();
        $shortenedUrl->title = $request->title;
        $shortenedUrl->description = $request->description;
        $shortenedUrl->save();
        $this->shortened_url = $shortenedUrl;
        return $this;
    }

    /**
     * Logs the clicks on every shortened URL's
     *
     * @param Illuminate\Http\Request;
     * @param cedaesca\UrlShortener\Models\ShortenedUrl
     * @return UrlShortenerService
     */
    public function log(Request $request)
    {
        $this->setRequest($request);
        $this->setShortened('shortlink', $this->request->shortlink);

        $data = [
            'agent' => $request->header('User-Agent'),
            'ip' => $request->ip(),
            'shortenedurl_id' => $this->shortened_url->id
        ];

        $this->visitor = Visitor::create($data);
        return $this;
    }

    /**
     * Set the property request
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the request property
     * 
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
