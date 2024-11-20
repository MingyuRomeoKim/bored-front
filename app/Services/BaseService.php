<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

class BaseService
{
    protected string $url;
    protected array $returnData = [
        'success' => true,
        'result' => null,
        'errorMessage' => null,
    ];

    public function __construct()
    {
        $this->url = env('API_URL');
    }

    public function isResponseFailed(Response $response): ?array
    {
        $errorMessage = null;

        if ($response->failed()) {
            $errorMessage = $response->json();

            if ($errorMessage === null) {
                $errorMessage = ['errorMessage' => $response->reason(), 'errorCode' => $response->status()];
            }

            if (json_validate($errorMessage['errorMessage'])) {
                $errorMessage = json_decode($errorMessage['errorMessage'], true);
            }
        }
        return $errorMessage;
    }
}