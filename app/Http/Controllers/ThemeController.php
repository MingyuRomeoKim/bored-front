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

class ThemeController extends Controller
{
    private CacheUtil $cacheUtil;

    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService, CacheUtil $cacheUtil)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
        $this->cacheUtil = $cacheUtil;
    }

    public function index(Request $request, string $themeId)
    {
        // chooseTheme
        $data['chooseTheme'] = $this->themeService->getTheme($themeId);
        $data['chooseRegion'] = $data['chooseTheme']['region'] ?? null;
        $data['themes'] = $this->themeService->getRegionThemesByRegionId($data['chooseRegion']['id']);

        // Posts
        $pageableDto = PageableDto::builder([
            'currentPageNo' => $request->query('currentPageNo', 1),
            'recordsPerPage' => $request->query('recordsPerPage', 10),
            'pageSize' => $request->query('pageSize', 10),
            'sort' => $request->query('sort', 'createdAt,desc'),
        ]);

        $result = $this->postService->getThemePostsByThemeId($data['chooseTheme']['id'], $pageableDto);
        $data['posts'] = $result['items'] ?? null;
        $data['pagination'] = $result['paginationInfo'] ?? null;


        return view('retro.region.list', $data);
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function write(string $themeId = null, string $themeTitleEn = null)
    {
        $accessToken = $this->getAccessTokenKey();

        $data['chooseTheme'] = $this->themeService->getTheme($themeId);
        $data['chooseRegion'] = $data['chooseTheme']['region'] ?? null;

        return view('retro.region.write', $data);
    }

    /**
     * @param Request $request
     * @param string|null $regionTitleEn
     * @param string|null $themeTitleEn
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, string $themeId)
    {
        $request->validateWithBag('write', [
            'title' => ['required'],
            'content' => [
                'required',
            ]
        ]);

        $accessToken = $this->getAccessTokenKey();

        $theme = $this->themeService->getTheme($themeId);

        $postCreateRequestDto = PostCreateRequestDto::builder([
            'title' => $request->post('title'),
            'content' => $request->post('content'),
            'ip' => $request->ip(),
            'themeId' => $theme['id'],
            'memberId' => $this->getUserData()['id'],
        ]);

        $this->postService->savePost($postCreateRequestDto, $accessToken);

        return redirect()->route('theme.index', ['themeId' => $themeId]);
    }

}
