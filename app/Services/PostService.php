<?php

namespace App\Services;

use App\Dtos\Requests\PageableDto;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class PostService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getLists(PageableDto $pageableDto) : Response
    {
        $url = $this->url . '/api/v1/article/post/lists';
        return Http::withQueryParameters($pageableDto->toArray())->get($url);
    }

    public function getPost(int $id) : ?Post
    {
        return $this->postRepository->getPostById($id) ?? null;
    }
}