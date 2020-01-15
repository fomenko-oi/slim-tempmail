<?php

namespace App\Infrastructure\Storage;

class UrlGenerator
{
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function url($path): string
    {
        return "{$this->baseUrl}/$path";
    }
}
