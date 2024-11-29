<?php

namespace App\Dtos\Requests;

use App\Traits\BuilderTrait;
use App\Traits\SingletonTrait;

class PostCreateRequestDto
{
    use SingletonTrait, BuilderTrait;

    protected string $title;
    protected string $titleEn;
    protected string $content;
    protected string $contentEn;
    protected string $ip;
    protected string $themeId;
    protected string $memberId;

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'titleEn' => $this->titleEn ?? $this->title,
            'content' => $this->content,
            'contentEn' => $this->contentEn ?? $this->content,
            'ip' => $this->ip,
            'themeId' => $this->themeId,
            'memberId' => $this->memberId,
        ];
    }
}