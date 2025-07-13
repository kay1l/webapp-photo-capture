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
public function fetchCaptures(Request $request, $albumId, $userId, $hash)
{
    $expectedHash = substr(hash('sha256', env('HASH_SECRET') . $albumId . $userId), 0, 16);
    if ($hash !== $expectedHash) {
        abort(403);
    }

    $latestFilename = $request->query('after');

    $query = Capture::where('album_id', $albumId)->orderBy('date_add', 'desc');

    if ($latestFilename) {
        $latestCapture = Capture::where('filename', $latestFilename)->first();
        if ($latestCapture) {
            $query->where('date_add', '>', $latestCapture->date_add);
        }
    }
    $captures = $query->get();

    if ($request->ajax()) {
        return view('partials._captures', ['captures' => $captures]);
    }

    return response()->json($captures);
}



}
