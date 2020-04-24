<?php

namespace cedaesca\UrlShortener\Services;

use Hashids\Hashids;
use cedaesca\UrlShortener\Models\ShortenedUrl;

class CodeGenerator
{
    /**
     * Hash the resource's ID to create an unique code
     * 
     * @return string
     */
    protected function make(): string
    {
        $hashids = new Hashids();

        do {
            $currentId = $this->getCurrentId();
        } while (ShortenedUrl::exists($currentId));

        return $hashids->encode($currentId);
    }

    /**
     * Get the ID of the current resource to be inserted
     * 
     * @return int
     */
    private function getCurrentId(): int
    {
        return ShortenedUrl::orderBy('created_at', 'desc')->first()->id + 1;
    }
}
