<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Exceptions\BoredTokenException;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function index(Request $request): \Illuminate\View\View
    {
        return view('retro.index');
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function show(string $articleId, Request $request): \Illuminate\View\View
    {
        $accessToken = $this->getAccessTokenKey();

        $this->authService->checkAccessToken($accessToken);

        $response = $this->postService->getDetail($articleId, $accessToken);

        $post = $response['result'];

        return view('retro/show', compact(
            'post'
        ));
    }
}
