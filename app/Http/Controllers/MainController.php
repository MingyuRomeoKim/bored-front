<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Dtos\Requests\PostCreateRequestDto;
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

    public function index(Request $request, string $regionId = null, string $themeId = null)
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

    public function show(string $articleId, Request $request)
    {
        $accessToken = $this->getAccessTokenKey();

        if (is_null($accessToken)) {
            return redirect()->back()->withErrors(['errorMessage' => '로그인이 필요합니다.'], 'login')->withInput();
        }

        $response = $this->authService->checkAccessToken($accessToken);
        $errorMessage = $this->isResponseFailed($response);
        if ($errorMessage !== null) {
            return redirect()->back()->withErrors($errorMessage, 'login')->withInput();
        }

        $response = $this->postService->getDetail($articleId, $accessToken);
        if (!$response['success']) {
            return redirect()->back()->withErrors($response['errorMessage'], 'login')->withInput();
        }
        $post = $response['result'];

        return view('retro/show', compact(
            'post'
        ));
    }

    public function write(Request $request)
    {
        $accessToken = $this->getAccessTokenKey();

        if ($accessToken === null) {
            return redirect()->back()->withErrors(['errorMessage' => '로그인이 필요합니다.'], 'login')->withInput();
        }

        $response = $this->authService->checkAccessToken($accessToken);
        $errorMessage = $this->isResponseFailed($response);
        if ($errorMessage !== null) {
            return redirect()->back()->withErrors($errorMessage, 'login')->withInput();
        }

        return view('retro/write');
    }

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
}
