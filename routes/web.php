<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotographerRemoteController;
use App\Http\Controllers\PhotographerController;
use App\Models\Album;
use App\Models\Capture;
use App\Models\User;
use App\Models\Remote;


Route::get('/', function () {
    $album = Album::has('captures')->latest()->firstOrFail();
    $captures = Capture::where('album_id', $album->id)
        ->orderBy('date_add', 'desc')
        ->get();
    $user = User::firstOrFail();
    $hash = substr(hash('sha256', env('HASH_SECRET') . $album->id . $user->id), 0, 16);

    return view('album', [
        'album' => $album,
        'user' => $user,
        'hash' => $hash,
        'captures' => $captures,
        'accessType' => $album->status === 'longterm' ? 'longterm' : 'live',
    ]);
})->name('home');

Route::middleware('validate.token')->group(function () {
    Route::get('/album/{album}/user/{user}/{hash}', [AlbumController::class, 'show'])->name('album.view');
    Route::get('/album/{album}/{user}/{hash}/captures', [AlbumController::class, 'fetchCaptures'])->name('album.captures');
});


Route::middleware('restore.session')->get('/album/restore', function () {
    return redirect('/')->with('error', 'Session could not be restored.');
});

Route::middleware('restore.session')->get('/photographer/remote/{deviceId}', [PhotographerRemoteController::class, 'handleRemote']);

Route::prefix('photographer')->name('photographer.')->group(function () {
    Route::post('/receive-link', [PhotographerController::class, 'receiveLink'])->name('receive-link');
    Route::post('/invite-email', [PhotographerController::class, 'inviteFriendEmail'])->name('invite-email');
    Route::post('/invite-qr', [PhotographerController::class, 'generateQr'])->name('invite-qr');
    Route::get('/download/{albumId}', [PhotographerController::class, 'downloadZip'])->name('download');
    Route::get('/remote/{device}/{hash}', [PhotographerController::class, 'startSession'])->name('start');
});





