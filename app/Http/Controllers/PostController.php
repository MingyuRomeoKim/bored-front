<?php

namespace App\Http\Controllers;

use App\Exceptions\BoredTokenException;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use App\Utils\CacheUtil;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private CacheUtil $cacheUtil;
    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService, CacheUtil $cacheUtil)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
        $this->cacheUtil = $cacheUtil;
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function show(string $postId): \Illuminate\View\View
    {
        $data['post'] = $this->postService->getDetail($postId);
        $data['chooseTheme'] = $data['post']['theme'];

        return view('retro.show', $data);
    }
}
