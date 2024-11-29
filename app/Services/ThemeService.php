<?php

namespace App\Services;

use App\Enums\CacheTtlStatus;
use App\Exceptions\BoredTokenException;
use Illuminate\Http\Client\ConnectionException;
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

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function findByTitleEn(String $titleEn, $accessToken)
    {
        $cacheKey = 'theme_detail_titleEn_' . $titleEn;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/theme/detail/' . $titleEn;

        $response = Http::withToken($accessToken)->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getRegionThemesByRegionId(string $regionId, string $accessToken)
    {
        $cacheKey = 'region_themes_' . $regionId;
        $url = $this->url . "/api/v1/article/region/{$regionId}/themes";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::withToken($accessToken)->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function getRegionThemesByRegionTitleEn(string $regionTitleEn, string $accessToken)
    {
        $cacheKey = 'region_themes_' . $regionTitleEn;
        $url = $this->url . "/api/v1/article/region/titleEn/{$regionTitleEn}/themes";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::withToken($accessToken)->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }
}