<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Services\AuthService;
use App\Services\BoardService;
use App\Services\PostService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private PostService $postService;
    private AuthService $authService;
    public function __construct(PostService $postService, AuthService $authService)
    {
        $this->postService = $postService;
        $this->authService = $authService;
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

        $posts = null;
        $pagination = null;

        if ($response->ok()) {
            $result = $response->json('result');
            $posts = $result['items'];
            $pagination = $result['paginationInfo'];
        }

        return view('retro/index', compact('posts', 'pagination'));
    }

    public function write(Request $request)
    {
        $accessToken = $request->cookie('accessToken');;

        if ($accessToken === null) {
            return redirect()->back()->withErrors(['errorMessage' => '로그인이 필요합니다.'], 'login')->withInput();
        }

        $response = $this->authService->checkAccessToken($accessToken);

        if ($response->failed()) {
            $errorMessageJson = $response->json();

            if ($errorMessageJson === null) {
                $errorMessageJson = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            }

            return redirect()->back()->withErrors($errorMessageJson, 'login')->withInput();
        }

        return view('retro/write');
    }
}
