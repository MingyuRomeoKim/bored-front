<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(PostService $postService, AuthService $authService, ThemeService $themeService, RegionService $regionService)
    {
        parent::__construct($postService, $authService, $themeService, $regionService);
    }

    /**
     * 로그인
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validateWithBag('login', [
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
            ]
        ]);

        $response = $this->authService->login($request);
        $errorMessage = $this->isResponseFailed($response);
        if ($errorMessage !== null) {
            return redirect()->back()->withErrors($errorMessage, 'login')->withInput();
        }


        $result = $response->json('result');
        $cookie = cookie('userData', json_encode($result), \env('JWT_EXPIRED_MIN'));

        return redirect()
            ->back()
            ->with('success', '축하드립니다! 로그인이 완료되었습니다.')
            ->cookie($cookie);
    }


    /**
     * 로그아웃
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $accessToken = $this->getAccessTokenKey();
        
        $response = $this->authService->logout($accessToken);

        // 쿠키 삭제
        cookie()->queue(cookie()->forget('userData'));

        return redirect('/')->with('success', '로그아웃 완료!');
    }

    /**
     * 회원가입
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signUp(Request $request): RedirectResponse
    {
        // validation check
        $request->validateWithBag('signUp', [
            'name' => 'required|string|min:2|max:10',
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:6',
                'max:20',
                'regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/',
            ],
            'passwordCheck' => 'required|same:password',
            'regionId' => 'required|string',
            'phone' => 'required|string|regex:/^01[0-9]{8,9}$/',
            'address' => 'required|string',
        ]);

        $response = $this->authService->signUp(request: $request);
        $errorMessage = $this->isResponseFailed($response);
        if ($errorMessage !== null) {
            return redirect()->back()->withErrors($errorMessage, 'signUp')->withInput();
        }


        return redirect()->back()->with('success', '축하드립니다! 회원가입이 완료되었습니다.');
    }
}
