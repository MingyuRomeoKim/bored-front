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
        $url = $this->url . '/api/v1/article/theme/' . $themeId . '/posts';

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url, $accessToken, $pageableDto) {
            $response = Http::withToken($accessToken)
                ->withQueryParameters($pageableDto->toArray())
                ->get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getThemePostsByThemeTitleEn(string $themeTitleEn, PageableDto $pageableDto)
    {
        $cacheKey = 'theme_posts_' . $themeTitleEn . '_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);
        $url = $this->url . '/api/v1/article/theme/titleEn/' . $themeTitleEn . '/posts';

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url, $pageableDto) {
            $response = Http::withQueryParameters($pageableDto->toArray())
                ->get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function getLists(PageableDto $pageableDto): array
    {
        $cacheKey = 'posts_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);
        $url = $this->url . '/api/v1/article/post/lists';

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url, $pageableDto) {
            $response = Http::withQueryParameters($pageableDto->toArray())->get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function getDetail(string $postId): array
    {
        $cacheKey = 'post_' . $postId;
        $url = $this->url . '/api/v1/article/post/detail/' . $postId;

        return Cache::remember($cacheKey, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM), function () use ($url) {
            $response = Http::get($url);
            $this->isResponseFailed($response);

            return $response->json('result');
        });
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