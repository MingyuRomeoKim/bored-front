<?php

namespace App\Services;

use App\Enums\CacheTtlStatus;
use Illuminate\Support\Facades\Cache;
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

    public function getRegionThemes(string $regionId, string $accessToken)
    {
        $cacheKey = 'region_themes_' . $regionId;
        $url = $this->url . "/api/v1/article/region/{$regionId}/themes";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::withToken($accessToken)->get($url);
        $errorMessage = $this->isResponseFailed($response);
        if ($errorMessage !== null) {
            $this->returnData['success'] = false;
            $this->returnData['errorMessage'] = $errorMessage;
            return $this->returnData;
        }

        if ($errorMessage !== null) {
            $this->returnData['success'] = false;
            $this->returnData['errorMessage'] = $errorMessage;
        }

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }
}