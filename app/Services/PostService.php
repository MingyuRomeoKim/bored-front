<?php

namespace App\Services;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
use App\Enums\CacheTtlStatus;
use App\Exceptions\BoredTokenException;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

class PostService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getThemePostsByThemeId(string $themeId, string $accessToken, PageableDto $pageableDto)
    {
        $cacheKey = 'theme_posts_' . $themeId . '_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/theme/' . $themeId . '/posts';

        $response = Http::withToken($accessToken)
            ->withQueryParameters($pageableDto->toArray())
            ->get($url);

        $this->isResponseFailed($response);


        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getThemePostsByThemeTitleEn(string $themeTitleEn, PageableDto $pageableDto)
    {
        $cacheKey = 'theme_posts_' . $themeTitleEn . '_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/theme/titleEn/' . $themeTitleEn . '/posts';

        $response = Http::withQueryParameters($pageableDto->toArray())
            ->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function getLists(PageableDto $pageableDto): array
    {
        $cacheKey = 'posts_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/post/lists';

        $response = Http::withQueryParameters($pageableDto->toArray())->get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getDetail(string $postId): array
    {
        $cacheKey = 'post_' . $postId;
//        if (Cache::has($cacheKey)) {
//            return Cache::get($cacheKey);
//        }

        $url = $this->url . '/api/v1/article/post/detail/' . $postId;
        $response = Http::get($url);
        $this->isResponseFailed($response);

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }


    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function savePost(PostCreateRequestDto $postCreateRequestDto, string $accessToken)
    {
        $url = $this->url . '/api/v1/article/post/create';

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $postCreateRequestDto->toArray());

        $this->isResponseFailed($response);

        return $response->json('result');
    }
}