<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class WbApiClient
{

    public function get(string $path, array $params = []):array
    {
     try {
        $params['key'] = config('services.wb.key');
        $response = Http::baseUrl(config('services.wb.base_url'))
        ->acceptJson()
        ->get($path, $params)
        ->throw();

        return $response->json();

    } catch (RequestException $e) {
        Log::error('Api Failed Guys', [
            'path' => $path,
            'params' => $params,
            'status' => $e->response?->status(),
            'body' => $e->response?->body(),
            'message' => $e->getMessage(),
        ]);
        throw $e;
        }
    }
}