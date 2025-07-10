<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\PhotographerController;

Route::get('/', function () {
    return view('welcome', [
        'album' => (object)['id' => 1, 'status' => 'live'],
        'user' => (object)['id' => 1],
        'hash' => 'dummyhash123',
        'captures' => collect([
            (object)['filename' => 'photo1.jpg'],
            (object)['filename' => 'photo2.jpg'],
            (object)['filename' => 'photo3.jpg'],
        ])
    ]);
})->name('home');

// Album view route with hash protection
Route::middleware('validate.token')->group(function () {
    Route::get('/album/{album}/{user}/{hash}', [AlbumController::class, 'show'])->name('album.view');
});

// Photographer functionality routes
Route::prefix('photographer')->name('photographer.')->group(function () {
    Route::post('/receive-link', [PhotographerController::class, 'receiveLink'])->name('receive-link');
    Route::post('/invite-email', [PhotographerController::class, 'inviteFriendEmail'])->name('invite-email');
    Route::post('/invite-qr', [PhotographerController::class, 'generateQr'])->name('invite-qr');
    Route::get('/download/{albumId}', [PhotographerController::class, 'downloadZip'])->name('download');
});
