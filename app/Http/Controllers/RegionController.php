<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
use App\Exceptions\BoredTokenException;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use App\Utils\CacheUtil;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    private CacheUtil $cacheUtil;
    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService, CacheUtil $cacheUtil)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
        $this->cacheUtil = $cacheUtil;
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function index(Request $request, string $regionId = null)
    {
        // themes
        $data['themes'] = $this->themeService->getRegionThemesByRegionId($regionId);
        $data['chooseRegion'] = $this->regionService->findById($regionId);

        return view('retro.region.list', $data);
    }

}
