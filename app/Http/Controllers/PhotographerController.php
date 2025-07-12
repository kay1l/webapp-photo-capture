<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\Album;
use App\Models\User;
use App\Models\Capture;
use App\Models\Invitation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PhotographerController extends Controller
{
    public function receiveLink(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'email' => 'required|email'
        ]);

        $album = Album::findOrFail($request->album_id);
        $user = User::create([
            'album_id' => $album->id,
            'email' => $request->email,
            'name' => null,
            'log' => ''
        ]);

        $token = Str::random(16);
        $secureUrl = route('album.view', [
            'albumId' => $album->id,
            'userId' => $user->id,
            'hash' => hash('sha256', "SALT123{$album->id}{$user->id}")
        ]);

        Mail::to($user->email)->send(new \App\Mail\SecureAlbumLink($secureUrl));

        return response()->json(['success' => true, 'message' => 'Secure link will be sent to email']);
    }

    public function inviteFriendEmail(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'friend_email' => 'required|email'
        ]);

        $album = Album::findOrFail($request->album_id);
        $newUser = User::create([
            'album_id' => $album->id,
            'email' => $request->friend_email,
            'name' => null,
            'log' => ''
        ]);

        $secureUrl = route('album.view', [
            'albumId' => $album->id,
            'userId' => $newUser->id,
            'hash' => hash('sha256', "SALT123{$album->id}{$newUser->id}")
        ]);

        // Email invitation
        Mail::to($request->friend_email)->send(new \App\Mail\AlbumInvite($secureUrl));

        return response()->json(['success' => true, 'message' => 'Invitation sent']);
    }

    public function generateQr(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id'
        ]);

        $album = Album::findOrFail($request->album_id);

        $existingUser =  User::where('album_id', $album->id)->orderBy('date_add', 'desc')->first();

        if($existingUser){
            $user = $existingUser;
        }else {
            $user = User::create([
                'album_id' => $album->id,
                'email' => null,
                'name' => null,
                'log' => '',
                'date_add' => now(),
            ]);
        }


        $hash = substr(hash('sha256', env('HASH_SECRET') . $album->id . $user->id), 0, 16);

        $url = route('album.view', [
            'album' => $album->id,
            'user' => $user->id,
            'hash' => $hash
        ]);


        $qrSvg = \QrCode::size(300)->generate($url);
        $svg_base64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        return response()->json([
            'success' => true,
            'url' => $url,
            'qr_svg' => $svg_base64
        ]);
    }

    public function downloadZip($albumId)
    {
        $album = Album::with('captures')->findOrFail($albumId);

        if ($album->status !== 'longterm') {
            return abort(403, 'Download not available yet.');
        }

        $zipFile = storage_path("app/public/album_{$album->id}.zip");

        // Optionally regenerate if not exists
        if (!file_exists($zipFile)) {
            $zip = new \ZipArchive;
            if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
                foreach ($album->captures as $capture) {
                    $photoPath = storage_path("app/public/photos/{$capture->filename}");
                    if (file_exists($photoPath)) {
                        $zip->addFile($photoPath, basename($photoPath));
                    }
                }
                $zip->close();
            }
        }

        return response()->download($zipFile);
    }
    public function startSession($deviceId, $hash){

    $expectedHash = substr(hash('sha256', 'SALT123' . $deviceId), 0, 16);
    if ($hash !== $expectedHash) {
        abort(403, 'Invalid device token');
    }

    $remote = Remote::findOrFail($deviceId);

    $liveAlbum = Album::where('remote_id', $remote->id)->where('status', 'live')->first();
    if ($liveAlbum) {
        abort(403, 'This device is already in use.');
    }

    $album = Album::create([
        'remote_id' => $remote->id,
        'venue_id' => $remote->venue_id,
        'date_add' => now(),
        'status' => 'live'
    ]);

    $user = User::create([
        'album_id' => $album->id,
        'email' => request()->get('email', null),
        'name' => null,
        'log' => ''
    ]);

    $secureHash = substr(hash('sha256', 'SALT123' . $album->id . $user->id), 0, 16);

    Cookie::queue(cookie('user_access_token', $secureHash, 43200));

    if ($user->email) {
        $url = route('album.view', [
            'album' => $album->id,
            'user' => $user->id,
            'hash' => $secureHash
        ]);
        Mail::to($user->email)->send(new \App\Mail\SecureAlbumLink($url));
    }

    return redirect()->route('album.view', [
        'album' => $album->id,
        'user' => $user->id,
        'hash' => $secureHash
    ]);
}
}
