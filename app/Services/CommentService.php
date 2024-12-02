<?php

namespace App\Services;

use App\Dtos\Requests\CommentCreateRequestDto;
use App\Utils\CacheUtil;
use Illuminate\Support\Facades\Http;

class CommentService extends BaseService
{
    private CacheUtil $cacheUtil;

    public function __construct(CacheUtil $cacheUtil)
    {
        parent::__construct();
        $this->cacheUtil = $cacheUtil;
    }

    public function save(CommentCreateRequestDto $commentCreateRequestDto, string $accessToken)
    {
        $url = $this->url . '/api/v1/article/comment/create';

        $response = Http::withToken($accessToken)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($url, $commentCreateRequestDto->toArray());

        $this->isResponseFailed($response);

        $this->cacheUtil->clearCacheByPattern('post_'.$commentCreateRequestDto->getPostId());

        return $response->json('result');
    }
}
