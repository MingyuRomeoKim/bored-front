<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
use App\Exceptions\BoredTokenException;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
    }

    /**
     * @throws ConnectionException
     * @throws BoredTokenException
     */
    public function index(Request $request, string $regionTitleEn = null, string $themeTitleEn = null)
    {
        $accessToken = $this->getAccessTokenKey();
        $data = [
            'posts' => null,
            'pagination' => null,
        ];

        // themes
        $data['themes'] = $this->fetchThemes($regionTitleEn, $accessToken);

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

            $response = $this->postService->getThemePostsByThemeTitleEn($themeTitleEn, $accessToken, $pageableDto);
            if (!$response['success']) {
                return redirect()->back()->withErrors($response['errorMessage'], 'errors')->withInput();
            }

            $result = $response['result'];
            $data['posts'] = $result['items'];
            $data['pagination'] = $result['paginationInfo'];
        }


        return view('retro.region.list', $data);
    }

    /**
     * @throws BoredTokenException
     * @throws ConnectionException
     */
    public function write(Request $request, string $regionTitleEn = null, string $themeTitleEn = null)
    {
        $accessToken = $this->getAccessTokenKey();
        $data = [
            'posts' => null,
            'pagination' => null,
        ];

        // themes
        $response = $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn, $accessToken);
        $data['themes'] = $response['result'];

        if (!is_null($themeTitleEn)) {
            $titleEnList = collect($data['themes'])->pluck('titleEn')->toArray();
            if (!in_array($themeTitleEn, $titleEnList)) {
                $response['errorMessage'] = ['status' => '404', 'message' => '테마가 존재하지 않습니다.'];
                return redirect()->back()->withErrors($response['errorMessage'], 'errors')->withInput();
            }
        }
        return view('retro/region/write', $data);

    }

    /**
     * @param Request $request
     * @return void
     */
    public function save(Request $request)
    {
        $request->validateWithBag('write', [
            'title' => ['required'],
            'content' => [
                'required',
            ]
        ]);

        $accessToken = $request->cookie('accessToken');;

        $postCreateRequestDto = PostCreateRequestDto::builder([
            'title' => $request->post('title'),
            'content' => $request->post('content'),
            'ip' => $request->ip(),
            'themeId' => $request->post('themeId'),
            'memberId' => $request->post('memberId')
        ]);

        $this->postService->savePost($postCreateRequestDto, $accessToken);

    }

    /**
     * Fetch themes for the given region.
     */
    private function fetchThemes(string $regionTitleEn, string $accessToken): array
    {
        $response = $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn, $accessToken);

        return $response['result'];
    }

}
