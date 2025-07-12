<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capture;

class AlbumController extends Controller
{

public function show($albumId, $userId, $hash)
{


    $album = Album::findOrFail($albumId);

    $accessType = $album->status === 'longterm' ? 'longterm' : 'live';
    $captures = Capture::where('album_id', $album->id)
        ->orderBy('date_add', 'desc')
        ->get();

    return view('welcome', [
        'album' => $album,
        'captures' => $captures,
        'accessType' => $accessType
    ]);
}

}
