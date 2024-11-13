<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthService
{
    private string $url;

    public function __construct()
    {
        $this->url = env('API_URL');
    }

    public function signUp(Request $request) :Response
    {
        $url = $this->url."/api/v1/auth/signup";

        $response = Http::post($url, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'passwordCheck' => $request->passwordCheck,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return $response;
    }
}