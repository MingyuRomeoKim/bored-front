<?php

namespace App\Http\Controllers;

use App\Exceptions\BoredErrorCode;
use App\Exceptions\BoredTokenException;
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

    public function isResponseFailed(Response $response): void
    {
        if ($response->failed()) {
            $errorMessage = $response->json();
            throw new BoredTokenException($errorMessage['errorMessage'], $errorMessage['errorCode']);
        }
    }

    public function getUserData(): ?array
    {
        $userData = json_decode(request()->cookie('userData'), true) ?? null;

        if (is_null($userData)) {
            return throw new BoredTokenException(BoredErrorCode::$COMMON_NOT_LOGIN['message'], BoredErrorCode::$COMMON_NOT_LOGIN['code']);
        }

        return $userData;
    }

    /**
     * @throws BoredTokenException
     */
    public function getAccessTokenKey(): ?string
    {
        $accessToken = $this->getUserData()['accessToken'] ?? null;

        if (is_null($accessToken)) {
            return throw new BoredTokenException(BoredErrorCode::$JWT_INVALID['message'], BoredErrorCode::$JWT_INVALID['code']);
        }

        return $accessToken;
    }
}
