<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Capture;
use App\Models\Album;


class CaptureSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album = Album::first();

        Capture::create([
            'album_id' => $album->id,
            'filename' => 'photo1.jpg',
            'date_add' => now(),
        ]);

        Capture::create([
            'album_id' => $album->id,
            'filename' => 'photo2.jpg',
            'date_add' => now(),
        ]);
    }
}
