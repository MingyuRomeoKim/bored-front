<?php

namespace App\Http\Controllers;

use App\Services\BoardService;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    private BoardService $boardService;
    public function __construct(BoardService $boardService) {
        $this->boardService = $boardService;
    }

    public function index()
    {

    }

    public function show(string $id)
    {
        $post = $this->boardService->getPost($id);
        return view('retro.board.show', compact('post','id'));
    }
}
