<?php
namespace App\Dtos\Requests;

use App\Traits\BuilderTrait;
use App\Traits\SingletonTrait;
class CommentCreateRequestDto
{
    use SingletonTrait, BuilderTrait;

    protected string $content;
    protected string $ip;
    protected string $postId;
    protected string $memberId;

    public function getPostId()
    {
        return $this->postId;
    }
}