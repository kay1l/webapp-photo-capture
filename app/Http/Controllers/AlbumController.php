<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capture;
use App\Models\Album;
class AlbumController extends Controller
{

public function show($albumId, $userId, $hash)
{


    $album = Album::findOrFail($albumId);

    $accessType = $album->status === 'longterm' ? 'longterm' : 'live';
    $captures = Capture::where('album_id', $album->id)
        ->orderBy('date_add', 'desc')
        ->get();

    return view('album', [
        'album' => $album,
        'captures' => $captures,
        'accessType' => $accessType
    ]);
}
public function fetchCaptures($albumId)
{
    $captures = Capture::where('album_id', $albumId)
        ->orderBy('date_add', 'desc')
        ->get(['id', 'filename']);

    return response()->json($captures);
}


}
