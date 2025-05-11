<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attempt extends Model
{
    use HasFactory;

    protected $fillable = ['puzzle_id', 'user_id', 'move_list', 'time_ms', 'is_valid'];

    protected $casts = [
        'move_list' => 'json',
        'is_valid' => 'boolean',
    ];

    public function puzzle()
    {
        return $this->belongsTo(Puzzle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
