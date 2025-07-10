<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $fillable = ['name'];

    public function albums() {
        return $this->hasMany(Album::class);
    }

    public function remotes() {
        return $this->hasMany(Remote::class);
    }

    public function photobooths() {
        return $this->hasMany(Photobooth::class);
    }
}
