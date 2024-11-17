<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\PostService;
use App\Services\RegionService;
use App\Services\ThemeService;
use http\Cookie;
use http\Env;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\exactly;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

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

        if ($response->failed()) {
            $errorMessageJson = $response->json();

            if ($errorMessageJson === null) {
                $errorMessageJson = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            }

            return redirect()->back()->withErrors($errorMessageJson, 'login')->withInput();
        }

        $result = $response->json('result');

        $accessTokenCookie = cookie('accessToken', $result['accessToken'], \env('JWT_EXPIRED_MIN'));
        $userIdCookie = cookie('userId', $result['id'], \env('JWT_EXPIRED_MIN'));
        $userNameCookie = cookie('userName', $result['name'], \env('JWT_EXPIRED_MIN'));
        $userEmailCookie = cookie('userEmail', $result['email'], \env('JWT_EXPIRED_MIN'));

        return redirect()
            ->back()
            ->with('success', '축하드립니다! 로그인이 완료되었습니다.')
            ->cookie($accessTokenCookie)
            ->cookie($userIdCookie)
            ->cookie($userNameCookie)
            ->cookie($userEmailCookie);

    }


    /**
     * 로그아웃
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $accessToken = $request->cookie()['accessToken'];

        $response = $this->authService->logout($accessToken);

        // 쿠키 삭제
        cookie()->queue(cookie()->forget('accessToken'));
        cookie()->queue(cookie()->forget('userEmail'));
        cookie()->queue(cookie()->forget('userId'));
        cookie()->queue(cookie()->forget('userName'));

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
            'phone' => 'required|string|regex:/^01[0-9]{8,9}$/',
            'address' => 'required|string',
        ]);

        $response = $this->authService->signUp(request: $request);

        if ($response->failed()) {
            $errorMessageJson = $response->json('errorMessage');

            if ($errorMessageJson === null) {
                $errorMessage = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            } else {
                $errorMessage = json_decode($errorMessageJson, true);
            }
            return redirect()->back()->withErrors($errorMessage, 'signUp')->withInput();
        }

        return redirect()->back()->with('success', '축하드립니다! 회원가입이 완료되었습니다.');
    }
}
