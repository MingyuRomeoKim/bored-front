<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\PageableDto;
use App\Services\BoardService;
use App\Services\PostService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
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

        return view('main', compact('posts', 'pagination'));
    }
}
