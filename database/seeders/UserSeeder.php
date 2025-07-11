<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Album;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $album = Album::first();

        User::create([
            'album_id' => $album->id,
            'email' => 'testuser@example.com',
            'name' => 'Test User',
            'log' => 'User created for testing.',
            'date_add' => now(),
            'password' => Hash::make('password123'),
        ]);
    }
}
