<?php

namespace App\Services;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;
use Symfony\Component\HttpFoundation\Response;

class CacheApiRequests extends BaseCacheProfile
{
    public function shouldCacheRequest(Request $request): bool
    {
        if ($this->isRunningInConsole()) {
            return false;
        }

        return $request->is('api/*');
    }

    public function shouldCacheResponse(Response $response): bool
    {
        return $response->isSuccessful() || $response->isRedirection();
    }
}
