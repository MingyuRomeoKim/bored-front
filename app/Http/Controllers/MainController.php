<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
use App\Exceptions\BoredTokenException;
use App\Services\AuthService;
use App\Services\BoardService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
    }

    public function index(Request $request)
    {
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

        return view('retro/index', compact(
            'posts',
            'pagination'
        ));
    }

    /**
     * @throws BoredTokenException
     */
    public function show(string $articleId, Request $request)
    {
        $accessToken = $this->getAccessTokenKey();

        $this->authService->checkAccessToken($accessToken);

        $response = $this->postService->getDetail($articleId, $accessToken);

        if (!$response['success']) {
            return redirect()->back()->withErrors($response['errorMessage'], 'login')->withInput();
        }
        $post = $response['result'];

        return view('retro/show', compact(
            'post'
        ));
    }
}
