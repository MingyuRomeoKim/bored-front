<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use http\Env;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    private AuthService $authService;


    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }

    public function signUp(Request $request)
    {
        // validation check
        $request->validateWithBag('signUp',[
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

        // 회원가입
        $response = $this->authService->signUp(request: $request);

        if ($response->failed()) {
            $errorMessageJson = $response->json('errorMessage');
            $errorMessage = json_decode($errorMessageJson,true);

            return redirect()->back()->withErrors($errorMessage, 'signUp')->withInput();
        }

        return redirect()->back()->with('success','회원가입이 완료되었습니다.');
    }
}
