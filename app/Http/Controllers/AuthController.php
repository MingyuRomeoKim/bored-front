<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use http\Env;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\exactly;

class AuthController extends Controller
{
    private AuthService $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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
            return redirect()->back()->withErrors($errorMessageJson, 'login')->withInput();
        }

        $result = $response->json('result');
        $accessTokenCookie = cookie('accessToken', $result['accessToken']);

        return redirect()->back()->with('success', '축하드립니다! 로그인이 완료되었습니다.')->cookie($accessTokenCookie);
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

        return redirect()->back()->with('success', '로그아웃 완료!');
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
            $errorMessage = json_decode($errorMessageJson, true);

            return redirect()->back()->withErrors($errorMessage, 'signUp')->withInput();
        }

        return redirect()->back()->with('success', '축하드립니다! 회원가입이 완료되었습니다.');
    }
}
