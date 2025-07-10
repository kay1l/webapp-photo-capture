<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumController;

// Route::get('/', function () {
//     return view('welcome');
// });



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
});
Route::get('/album/{album}/{user}/{hash}', [AlbumController::class, 'show'])->name('album.view');
