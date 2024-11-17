<?php

namespace App\Dtos\Requests;

use App\Traits\BuilderTrait;
use App\Traits\SingletonTrait;

class PostCreateRequestDto
{
    use SingletonTrait, BuilderTrait;

    protected string $title;
    protected string $content;
    protected string $ip;
    protected string $themeId;
    protected string $memberId;
}