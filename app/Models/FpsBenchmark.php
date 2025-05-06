<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FpsBenchmark extends Model
{
    protected $fillable = ['game_title', 'cpu_model', 'gpu_model', 'average_fps', 'resolution'];
}
