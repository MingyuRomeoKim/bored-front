<?php

namespace App\Services;

class BaseService
{
    protected string $url;

    public function __construct()
    {
        $this->url = env('API_URL');
    }
}