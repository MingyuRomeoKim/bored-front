<?php

namespace App\Http\Controllers;

use App\Dtos\Requests\CommentCreateRequestDto;
use App\Services\AuthService;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private CommentService $commentService;
    public function __construct(
        PostService $postService,
        AuthService $authService,
        ThemeService $themeService,
        RegionService $regionService,
        CommentService $commentService
    )
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
        $this->commentService = $commentService;
    }

    public function save(Request $request, string $postId)
    {
        $request->validateWithBag('write', [
            'content' => ['required']
        ]);

        $userData = $this->getUserData();
        $accessToken = $userData['accessToken'];

        $commentCreateRequestDto = CommentCreateRequestDto::builder([
            'content' => $request->input('content'),
            'ip' => $request->ip(),
            'postId' => $postId,
            'memberId' => $userData['id'],
        ]);

        $response = $this->commentService->save($commentCreateRequestDto, $accessToken);

        return redirect()->back()->with('success', '댓글이 등록되었습니다.');
    }
}
