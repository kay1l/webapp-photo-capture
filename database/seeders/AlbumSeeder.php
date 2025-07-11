<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Album;
use App\Models\Remote;
use App\Models\Venue;


class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remote = Remote::first();
        $venue = Venue::first();

        Album::create([
            'remote_id' => $remote->id,
            'venue_id' => $venue->id,
            'date_add' => now(),
            'date_over' => now()->addHours(1),
            'date_upd' => now(),
            'status' => 'live',
        ]);
    }
}
