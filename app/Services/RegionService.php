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
        $url = $this->url . '/api/v1/article/region/lists';

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
        $cacheKey = 'region_detail_titleEn_' . $titleEn;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/region/detail/' . $titleEn;

        $response = Http::withToken($accessToken)->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }
}