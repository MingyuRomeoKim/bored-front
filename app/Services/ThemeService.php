<?php

namespace App\Services;

use App\Enums\CacheTtlStatus;
use App\Exceptions\BoredTokenException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class ThemeService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getThemes() {
        $cacheKey = 'theme_lists';
        $url = $this->url . '/api/v1/article/theme/lists';;

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url) {
            $response = Http::get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function findByTitleEn(String $titleEn, $accessToken)
    {
        $cacheKey = 'theme_detail_titleEn_' . $titleEn;
        $url = $this->url . '/api/v1/article/theme/detail/' . $titleEn;

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url, $accessToken) {
            $response = Http::withToken($accessToken)->get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getRegionThemesByRegionId(string $regionId, string $accessToken)
    {
        $cacheKey = 'region_themes_' . $regionId;
        $url = $this->url . "/api/v1/article/region/{$regionId}/themes";

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url, $accessToken) {
            $response = Http::withToken($accessToken)->get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function getRegionThemesByRegionTitleEn(string $regionTitleEn)
    {
        $cacheKey = 'region_themes_' . $regionTitleEn;
        $url = $this->url . "/api/v1/article/region/titleEn/{$regionTitleEn}/themes";

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url) {
            $response = Http::get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }
}