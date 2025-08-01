<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remote extends Model
{
    protected $fillable = ['venue_id'];

    public function venue() {
        return $this->belongsTo(Venue::class);
    }
}
