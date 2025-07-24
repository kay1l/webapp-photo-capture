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

        // Create album record
        $album = Album::create([
            'remote_id' => $deviceId,
            'status' => 'live',
            'date_add' => now(),
            'date_upd' => now(),
            'venue_id' => $venueId,
        ]);

        // Load names from JSON file in resources/data/names.json
        $path = resource_path('data/names.json');
        $names = json_decode(file_get_contents($path), true);

        if (empty($names)) {
            abort(500, 'No names found in JSON.');
        }

        $randomName = $names[array_rand($names)];


        $sanitizedEmail = strtolower(str_replace(' ', '.', $randomName)) . rand(1000, 9999) . '@gmail.com';

        $user = User::create([
            'album_id' => $album->id,
            'name' => $randomName,
            'email' => $sanitizedEmail,
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
