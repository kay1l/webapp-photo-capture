<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Album;
use App\Models\User;

class PhotographerRemoteController extends Controller
{
    public function handleRemote($deviceId)
    {
        $venueId = 1;

        $album = Album::create([
            'remote_id' => $deviceId,
            'status' => 'live',
            'date_add' => now(),
            'date_upd' => now(),
            'venue_id' => $venueId,
        ]);

        $user = User::create([
            'album_id' => $album->id,
            'name' => 'New User',
            'email' => 'testing@gmail.com',
            'date_add' => now(),
        ]);

        $hash = substr(hash('sha256', env('HASH_SECRET') . $album->id . $user->id), 0, 16);

        $cookie = cookie('user_access_token', $hash, 43200);

        return redirect()->route('album.view', [
            'album' => $album->id,
            'user' => $user->id,
            'hash' => $hash,
        ])->withCookie($cookie);
    }
}
