<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    public function getAllPosts()
    {
        return Post::all();
    }

    public function getPostById($postId)
    {
        return Post::findOrFail($postId);
    }

    public function createPost(array $postDetails)
    {
        return Post::create($postDetails);
    }

    public function updatePost($postId, array $newDetails)
    {
        return Post::whereId($postId)->update($newDetails);
    }

    public function deletePost($postId)
    {
        return Post::destroy($postId);
    }
}