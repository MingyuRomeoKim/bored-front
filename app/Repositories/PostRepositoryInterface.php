<?php

namespace App\Repositories;

interface PostRepositoryInterface
{
    public function getAllPosts();

    public function getPostById($postId);

    public function createPost(array $postDetails);

    public function updatePost($postId, array $newDetails);

    public function deletePost($postId);
}