<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function show($albumId, $userId, $hash)
    {
        $album = Album::findOrFail($albumId);
        $user = User::findOrFail($userId);
        $captures = Capture::where('album_id', $albumId)->latest()->get();

        return view('album.index', compact('album', 'user', 'hash', 'captures'));
    }

}
