<?php

namespace App\Http\Controllers;

use App\Services\BoardService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    private BoardService $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    public function index()
    {
        $posts = $this->boardService->getAllPosts();
        return view('main',compact('posts'));
    }
}
