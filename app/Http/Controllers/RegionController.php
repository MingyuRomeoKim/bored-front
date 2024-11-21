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

        // themes
        $response = $this->themeService->getRegionThemes($regionId, $accessToken);
        if (!$response['success']) {
            return redirect()->back()->withErrors($response['errorMessage'], 'login')->withInput();
        }
        $themes = $response['result'];

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
        $posts = $result['items'];
        $pagination = $result['paginationInfo'];

        return view('retro.region.list', compact(
            'posts',
            'pagination',
            'themes'
        ));
    }
}
