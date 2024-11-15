<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login(Request $request) : Response
    {
        $url = $this->url . '/api/v1/auth/login';

        return Http::post($url, [
            'email' => $request->email,
            'password' => $request->password
        ]);
    }

    public function logout(string $accessToken) : Response
    {
        $url = $this->url . '/api/v1/auth/logout';

        return Http::withToken($accessToken)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->delete($url);
    }

    public function signUp(Request $request) :Response
    {
        $url = $this->url."/api/v1/auth/signup";

        return Http::post($url, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'passwordCheck' => $request->passwordCheck,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    }

    public function checkAccessToken(string $accessToken) : Response
    {
        $url = $this->url . '/api/v1/auth/check/accessToken';

        return Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->get($url);
    }
}