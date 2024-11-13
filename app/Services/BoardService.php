<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;

class BoardService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts() : ?array
    {
        return $this->postRepository->getAllPosts()->toArray() ?? null;
    }

    public function getPost(int $id) : ?Post
    {
        return $this->postRepository->getPostById($id) ?? null;
    }
}