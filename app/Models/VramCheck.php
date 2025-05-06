<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VramCheck extends Model
{
    protected $fillable = [
        'vram_mb',
        'texture_pack_mb',
        'status',
    ];
}
