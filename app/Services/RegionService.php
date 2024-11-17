<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RegionService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRegions()
    {
        $url = $this->url . '/api/v1/article/region/lists';

        $response = Http::get($url);

        if ($response->status() == 200) {
            return $response->json('result');
        }

        return null;
    }
}