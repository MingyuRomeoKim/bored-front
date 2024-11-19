<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;

abstract class Controller
{
    protected PostService $postService;
    protected AuthService $authService;
    protected ThemeService $themeService;
    protected RegionService $regionService;

    public function __construct(
        PostService $postService,
        AuthService $authService,
        ThemeService $themeService,
        RegionService $regionService
    )
    {
        $this->postService = $postService;
        $this->authService = $authService;
        $this->themeService = $themeService;
        $this->regionService = $regionService;
    }
}
