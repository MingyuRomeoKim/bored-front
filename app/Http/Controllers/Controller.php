<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Client\Response;

abstract class Controller
{
    protected PostService $postService;
    protected AuthService $authService;
    protected ThemeService $themeService;
    protected RegionService $regionService;

    public function __construct(
        PostService   $postService,
        AuthService   $authService,
        ThemeService  $themeService,
        RegionService $regionService
    )
    {
        $this->postService = $postService;
        $this->authService = $authService;
        $this->themeService = $themeService;
        $this->regionService = $regionService;
    }

    public function isResponseFailed(Response $response): ?array
    {
        $errorMessage = null;

        if ($response->failed()) {
            $errorMessage = $response->json();

            if ($errorMessage === null) {
                $errorMessage = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            }

            if (json_validate($errorMessage['errorMessage'])) {
                $errorMessage = json_decode($errorMessage['errorMessage'], true);
            }
        }
        return $errorMessage;
    }

    public function getUserData(): ?array
    {
        return json_decode(request()->cookie('userData'), true) ?? null;
    }

    public function getAccessTokenKey(): ?string
    {
        return $this->getUserData()['accessToken'] ?? null;
    }
}
