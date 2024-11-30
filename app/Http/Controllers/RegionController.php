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
    public function index(Request $request, string $regionTitleEn = null, string $themeTitleEn = null)
    {

        $data = [
            'posts' => null,
            'pagination' => null,
        ];

        // themes
        $data['themes'] = $this->fetchThemes($regionTitleEn);

        if (!is_null($themeTitleEn)) {
            $titleEnList = collect($data['themes'])->pluck('titleEn')->toArray();
            if (!in_array($themeTitleEn, $titleEnList)) {
                $response['errorMessage'] = ['status' => '404', 'message' => '테마가 존재하지 않습니다.'];
                return redirect()->back()->withErrors($response['errorMessage'], 'errors')->withInput();
            }

            $pageableDto = PageableDto::builder([
                'currentPageNo' => $request->query('currentPageNo', 1),
                'recordsPerPage' => $request->query('recordsPerPage', 10),
                'pageSize' => $request->query('pageSize', 10),
                'sort' => $request->query('sort', 'createdAt,desc'),
            ]);

            $result = $this->postService->getThemePostsByThemeTitleEn($themeTitleEn, $pageableDto);

            $data['posts'] = $result['items'];
            $data['pagination'] = $result['paginationInfo'];
        }


        return view('retro.region.list', $data);
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function write(string $regionTitleEn = null, string $themeTitleEn = null)
    {
        $accessToken = $this->getAccessTokenKey();

        $data = [
            'posts' => null,
            'pagination' => null,
        ];

        $data['themes'] = $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn);

        if (!is_null($themeTitleEn)) {
            $titleEnList = collect($data['themes'])->pluck('titleEn')->toArray();
            if (!in_array($themeTitleEn, $titleEnList)) {
                $response['errorMessage'] = ['status' => '404', 'message' => '테마가 존재하지 않습니다.'];
                return redirect()->back()->withErrors($response['errorMessage'], 'errors')->withInput();
            }
        }

        return view('retro.region.write', $data);
    }

    /**
     * @param Request $request
     * @param string|null $regionTitleEn
     * @param string|null $themeTitleEn
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, string $regionTitleEn = null, string $themeTitleEn = null)
    {
        $request->validateWithBag('write', [
            'title' => ['required'],
            'content' => [
                'required',
            ]
        ]);

        $accessToken = $this->getAccessTokenKey();

        $theme = $this->themeService->findByTitleEn($themeTitleEn, $accessToken);

        $postCreateRequestDto = PostCreateRequestDto::builder([
            'title' => $request->post('title'),
            'content' => $request->post('content'),
            'ip' => $request->ip(),
            'themeId' => $theme['id'],
            'memberId' => $this->getUserData()['id'],
        ]);

        $this->postService->savePost($postCreateRequestDto, $accessToken);

        return redirect()->route('region.theme.index', ['regionTitleEn' => $regionTitleEn, 'themeTitleEn' => $themeTitleEn]);
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function show(string $regionTitleEn, string $themeTitleEn, string $postId): \Illuminate\View\View
    {
        $data['themes'] = $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn);
        $data['post'] = $this->postService->getDetail($postId);

        return view('retro/show', $data);
    }

    /**
     * Fetch themes for the given region.
     */
    private function fetchThemes(string $regionTitleEn): array
    {
        return $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn);
    }

}
