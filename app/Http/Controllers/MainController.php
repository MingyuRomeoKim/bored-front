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

    public function index(Request $request)
    {
        $pageableDto = PageableDto::builder([
            'currentPageNo' => $request->query('currentPageNo', 1),
            'recordsPerPage' => $request->query('recordsPerPage', 10),
            'pageSize' => $request->query('pageSize', 10),
            'sort' => $request->query('sort', 'createdAt,desc'),
        ]);

        $response = $this->postService->getLists($pageableDto);
        $themes = $this->themes;
        $regions = $this->regions;

        $posts = null;
        $pagination = null;

        if ($response->ok()) {
            $result = $response->json('result');
            $posts = $result['items'];
            $pagination = $result['paginationInfo'];
        }

        return view('retro/index', compact(
            'posts',
            'pagination',
            'themes',
            'regions',
        ));
    }

    public function show(string $articleId)
    {
        $this->postService->
    }

    public function write(Request $request)
    {
        $accessToken = $request->cookie('accessToken');;
        $themes = $this->themes;
        $regions = $this->regions;

        if ($accessToken === null) {
            return redirect()->back()->withErrors(['errorMessage' => '로그인이 필요합니다.'], 'login')->withInput();
        }

        $response = $this->authService->checkAccessToken($accessToken);

        if ($response->failed()) {
            cookie()->queue(cookie()->forget('accessToken'));
            $errorMessageJson = $response->json();
            if ($errorMessageJson === null) {
                $errorMessage = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            } else {
                $errorMessage = ['errorMessage' => $errorMessageJson['errorCode'], 'errorCode' => $errorMessageJson['errorMessage']];
            }

            return redirect()->back()->withErrors($errorMessage, 'login')->withInput();
        }

        return view('retro/write', compact(
            'themes',
            'regions',
        ));
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
