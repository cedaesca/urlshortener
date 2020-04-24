<?php

/**
 * @author César Escudero <cedaesca@gmail.com>
 * @package cedaesca\UrlShortener
 * @copyright © 2020 César Escudero, all rights reserved worldwide
 */

namespace cedaesca\UrlShortener\Services;

use cedaesca\UrlShortener\Models\ShortenedUrl;

class UrlShortener
{
    /**
     * Original URL
     * 
     * @var string
     */
    private $target;

    /**
     * Shortened Url's creator
     * 
     * @var string
     */
    private $creator;

    /**
     * Shortened Url's Title
     * 
     * @var string
     */
    private $title;

    /**
     * Shortened Url's Description
     * 
     * @var string
     */
    private $description;

    /**
     * Code Generator Object
     * 
     * @var CodeGenerator
     */
    private $codeGenerator;

    /**
     * Creates a new UrlShortener instance
     * 
     * @return void
     */
    public function __construct(CodeGenerator $codeGenerator)
    {
        $this->codeGenerator = $codeGenerator;

        $this->target = null;
        $this->creator = null;
        $this->title = null;
        $this->description = null;
    }


    /**
     * Stores a new shortened URL
     * 
     * @return \cedaesca\UrlShortener\Models\ShortenedUrl
     */
    public function make(): ShortenedUrl
    {
        return tap(ShortenedUrl::create([
            'created_by' => $this->creator->id,
            'code' => '_placeholder_',
            'target' => $this->target,
            'title' => $this->title,
            'description' => $this->description
        ]), function ($shortenedUrl) {
            // Since we are hashing the ID's to generate
            // an unique code, we are first saving the
            // resource so then we can retrive the id and
            // use it as an argument for the hasher.
            $shortenedUrl->code = $shortenedUrl->generateCode();
            $shortenedUrl->save();
        });
    }

    /**
     * Set the original url
     * 
     * @param string $target
     * 
     * @return self
     */
    public function target(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Sets the shortened URL creator
     * 
     * @param mixed $model      Expects a model instance of the creator
     * 
     * @return self
     */
    public function creator($model): self
    {
        if (!$model instanceof \Illuminate\Database\Eloquent\Model) {
            throw new \Exception("Unexpected 'model' given as argument: {$model}");
        }

        $this->creator = $model;

        return $this;
    }

    /**
     * Set the shortened URL's details
     * 
     * @param array $array      Must contain the title and/or the description
     * 
     * @return self
     */
    public function details(array $details): self
    {
        $this->title = $details['title'] ?? null;
        $this->description = $details['description'] ?? null;

        return $this;
    }
}
