<?php

namespace App\Services;

use App\Enums\CacheTtlStatus;
use App\Exceptions\BoredTokenException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RegionService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRegions()
    {
        $cacheKey = 'region_lists';
        $url = $this->url . '/api/v1/article/region/lists';

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url) {
            $response = Http::get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    public function findById(String $regionId)
    {
        $cacheKey = 'region_detail_' . $regionId;
        $url = $this->url . '/api/v1/article/region/' . $regionId;

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
    public function findByTitleEn(String $titleEn)
    {
        $cacheKey = 'region_detail_titleEn_' . $titleEn;
        $url = $this->url . '/api/v1/article/region/detail/' . $titleEn;

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url) {
            $response = Http::get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }
}