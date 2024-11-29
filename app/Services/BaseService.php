<?php

namespace App\Services;

use App\Exceptions\BoredTokenException;
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

    /**
     * @throws BoredTokenException
     */
    public function isResponseFailed(Response $response): void
    {
        if ($response->failed()) {
            $errorMessage = $response->json();
            dd($errorMessage);
            throw new BoredTokenException($errorMessage['errorMessage'], $errorMessage['errorCode']);
        }
    }
}