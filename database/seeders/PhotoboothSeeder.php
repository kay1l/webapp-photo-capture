<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Photobooth;
use App\Models\Venue;

class PhotoboothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venue = Venue::first();
        Photobooth::create([
            'venue_id' => $venue->id,
            'name' => 'Booth 1',
        ]);
    }
}
