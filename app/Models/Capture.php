<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Capture extends Model
{
    use HasFactory;

    protected $fillable = [
        'album_id',
        'filename',
        'date_add',
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
