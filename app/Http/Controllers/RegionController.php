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

    public function index(Request $request, string $regionId = null, string $themeId = null)
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
        $response = $this->themeService->getRegionThemes($regionId, $accessToken);
        if (!$response['success']) {
            return redirect()->back()->withErrors($response['errorMessage'], 'login')->withInput();
        }
        $data['themes'] = $response['result'];

        if (!is_null($themeId)) {
            $pageableDto = PageableDto::builder([
                'currentPageNo' => $request->query('currentPageNo', 1),
                'recordsPerPage' => $request->query('recordsPerPage', 10),
                'pageSize' => $request->query('pageSize', 10),
                'sort' => $request->query('sort', 'createdAt,desc'),
            ]);

            $response = $this->postService->getLists($pageableDto);

            if (!$response['success']) {
                return redirect()->back()->withErrors($response['errorMessage'], 'login')->withInput();
            }

            $result = $response['result'];
            $data['posts'] = $result['items'];
            $data['pagination'] = $result['paginationInfo'];
        }


        return view('retro.region.list', $data);
    }
}
