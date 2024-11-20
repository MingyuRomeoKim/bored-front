<?php

namespace App\Services;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
use App\Enums\CacheTtlStatus;
use App\Models\Post;
use App\Repositories\PostRepository;
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

    public function getLists(PageableDto $pageableDto): array
    {
        $cacheKey = 'posts_' . Arr::join($pageableDto->toArray(), '_');
        $cacheKey = Str::replace(',', '_', $cacheKey);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/post/lists';

        $response = Http::withQueryParameters($pageableDto->toArray())->get($url);
        $errorMessage = $this->isResponseFailed($response);

        if ($errorMessage !== null) {
            $this->returnData['success'] = false;
            $this->returnData['errorMessage'] = $errorMessage;
        }

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }

    public function getDetail(string $postId, string $accessToken): array
    {
        $cacheKey = 'post_' . $postId;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = $this->url . '/api/v1/article/post/detail/' . $postId;
        $response = Http::withToken($accessToken)->get($url);
        $errorMessage = $this->isResponseFailed($response);

        if ($errorMessage !== null) {
            $this->returnData['success'] = false;
            $this->returnData['errorMessage'] = $errorMessage;
        }

        $this->returnData['result'] = $response->json('result');
        Cache::put($cacheKey, $this->returnData, CacheTtlStatus::getTtl(CacheTtlStatus::MEDIUM));

        return $this->returnData;
    }


    public function savePost(PostCreateRequestDto $postCreateRequestDto, string $accessToken)
    {
        $url = $this->url . '/api/v1/article/post/create';

        $response = Http::withToken($accessToken)
            ->post($url, $postCreateRequestDto);

        dd($response);
    }
}