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

       for ($i = 1; $i <= 21; $i++) {
        Capture::create([
            'album_id' => $album->id,
            'filename' => "img_{$i}.jpg",
            'date_add' => now(),
        ]);
       }
       $this->command->info('21 captures inserted.');

    }
}
