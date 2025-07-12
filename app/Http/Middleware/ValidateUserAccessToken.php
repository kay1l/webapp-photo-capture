<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUserAccessToken
{
    public function handle($request, Closure $next)
    {
        $userId = $request->route('user');
        $albumId = $request->route('album');
        $hash = $request->route('hash');

        $expectedHash = substr(hash('sha256', env('HASH_SECRET') . $albumId . $userId), 0, 16);

        if ($hash !== $expectedHash) {
            abort(403, 'Access denied');
        }

        $cookie = $request->cookie('user_access_token');

        if (!$cookie || $cookie !== $expectedHash) {

            cookie()->queue(cookie('user_access_token', $expectedHash, 43200));
        }

        return $next($request);
    }
}

