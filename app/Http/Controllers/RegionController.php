<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
    }

    public function index(Request $request, string $regionTitleEn = null, string $themeTitleEn = null)
    {
        $accessToken = $this->getAccessTokenKey();
        $data = [
            'themes' => null,
            'posts' => null,
            'pagination' => null,
        ];
        if (is_null($accessToken)) {
            return redirect()->back()->withErrors(['errorMessage' => '로그인이 필요합니다.'], 'login')->withInput();
        }

        // themes
        $response = $this->themeService->getRegionThemesByRegionTitleEn($regionTitleEn, $accessToken);
        if (!$response['success']) {
            return redirect()->back()->withErrors($response['errorMessage'], 'errors')->withInput();
        }

        $data['themes'] = $response['result'];

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
}
