<?php

namespace App\Observers;

use App\Models\Album;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SecureAlbumLink;

class AlbumObserver
{
    public function created(Album $album): void
    {
        //
    }

    public function updated(Album $album): void
    {
        if ($album->isDirty('status') && $album->status === 'longterm') {
            $originalStatus = $album->getOriginal('status');

            if ($originalStatus !== 'longterm') {
                $users = $album->users;

                foreach ($users as $user) {
                    if (!$user->email) {
                        Log::warning("User ID {$user->id} has no email.");
                        continue;
                    }


                    $hash = substr(hash('sha256', 'SALT123' . $album->id . $user->id), 0, 16);
                    $secureUrl = route('album.view', [
                        'album' => $album->id,
                        'user' => $user->id,
                        'hash' => $hash,
                    ]);

                    try {
                        Mail::to($user->email)->send(new SecureAlbumLink($secureUrl));
                        Log::info("Sent album link email to {$user->email} for album {$album->id}");
                    } catch (\Exception $e) {
                        Log::error('Failed sending album link email: ' . $e->getMessage());
                    }
                }
            }
        }
    }


    public function deleted(Album $album): void
    {
        //
    }

    public function restored(Album $album): void
    {
        //
    }

    public function forceDeleted(Album $album): void
    {
        //
    }
}
