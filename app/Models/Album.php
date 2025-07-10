<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Album.php
class Album extends Model
{
    protected $guarded = [];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function captures() {
        return $this->hasMany(Capture::class);
    }
}

