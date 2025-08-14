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
use Flasher\Laravel\Facade\Flasher;
use App\Mail\SecureAlbumLink;
use App\Mail\AlbumInvite;
use Illuminate\Support\Facades\Log;
use App\Models\Remote;


class PhotographerController extends Controller
{
    private function generateAlbumHash($albumId, $userId)
    {
        return substr(hash('sha256','SALT123' . $albumId . $userId), 0, 16);
    }
    public function receiveLink(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id',
            'email' => 'required|email'
        ]);

        $album = Album::findOrFail($request->album_id);

        $user = User::where('album_id', $album->id)
            ->firstOrFail();

        $user->email = $request->email;
        $user->save();

        $token = Str::random(16);
        $hash = $this->generateAlbumHash($album->id, $user->id);
        $secureUrl = route('album.view', [
            'album' => $album->id,
            'user' => $user,
            'hash' => $hash
        ]);

        try {
            Log::info('Sending email to: ' . $request->email);
            Log::info('Secure URL: ' . $secureUrl);
            Mail::to($request->email)->send(new SecureAlbumLink($secureUrl));
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: unable to send email.'
            ], 500);
        }
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
            'log' => 'User created for invite a friend'

        ]);
        $hash = $this->generateAlbumHash($album->id, $newUser->id);
        $secureUrl = route('album.view', [
            'album' => $album->id,
            'user' => $newUser->id,
            'hash' => $hash
        ]);

       try {
        Log::info("Inviting friend via email: " . $request->friend_email);
        Log::info("Generated secured url: " . $secureUrl);
        Mail::to($request->friend_email)->send(new AlbumInvite($secureUrl));
        return response()->json(['success' => true], 200);
       } catch (\Exception $e) {
        Log::error("Invite failed to send: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Server error: unable to send invitation email.'
        ], 500);
       }


    }

    public function generateQr(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:albums,id'
        ]);

        $album = Album::findOrFail($request->album_id);

        $path = resource_path('data/names.json');
        $names = json_decode(file_get_contents($path), true);

        if (empty($names)) {
            abort(500, 'No names found in JSON.');
        }

        $randomName = $names[array_rand($names)];

            $user = User::create([
                'album_id' => $album->id,
                'email' => null,
                'name' => $randomName,
                'log' => 'Created user from QR invite',
                'date_add' => now(),
            ]);

        $hash = $this->generateAlbumHash($album->id, $user->id);

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

        if (!file_exists($zipFile)) {
            $zip = new \ZipArchive;
            if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
                foreach ($album->captures as $capture) {
                    $photoPath = storage_path("app/public/images/{$capture->filename}");
                    if (file_exists($photoPath)) {
                        $zip->addFile($photoPath, basename($photoPath));
                    } else {
                        \Log::warning("Missing image: {$photoPath}");
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

    $path = resource_path('data/names.json');
    $names = json_decode(file_get_contents($path), true);

    if (empty($names)) {
        abort(500, 'No names found in JSON.');
    }

    $randomName = $names[array_rand($names)];

    // $sanitizedEmail = strtolower(str_replace(' ', '.', $randomName)) . rand(1000, 9999) . '@gmail.com';

    $user = User::create([
        'album_id' => $album->id,
        'name' => $randomName,
        // 'email' => $sanitizedEmail,
        'date_add' => now(),
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
