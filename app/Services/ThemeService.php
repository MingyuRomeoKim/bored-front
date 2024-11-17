<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ThemeService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getThemes() {
        $url = $this->url . '/api/v1/article/theme/lists';;

        $response = Http::get($url);

        if ($response->status() == 200) {
            return $response->json('result');
        }

        return null;
    }
}