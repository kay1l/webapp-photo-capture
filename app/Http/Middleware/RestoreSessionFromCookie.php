<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
class RestoreSessionFromCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->route('album') && $request->route('user') && $request->route('hash')) {
            return $next($request);
        }

        $token = $request->cookie('user_access_token');

        if (!$token) {
            return $next($request);
        }
        $user = null;
        $album = null;

        foreach (User::latest()->take(100)->get() as $u) {
            $expected = substr(hash('sha256', env('HASH_SECRET') . $u->album_id . $u->id), 0, 16);
            if ($expected === $token) {
                $user = $u;
                $album = $u->album;
                break;
            }
        }

        if ($user && $album) {

            return redirect()->route('album.view', [
                'album' => $album->id,
                'user' => $user->id,
                'hash' => $token,
            ]);
        }

        return $next($request);
    }
}
