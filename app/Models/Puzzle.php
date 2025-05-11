<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Puzzle extends Model
{
    use HasFactory;

    protected $fillable = ['name','date', 'seed', 'grid_data'];

    protected $casts = [
        'date' => 'date',
    ];

 

    public function attempts() {
        return $this->hasMany(Attempt::class);
    }

    public function cells()
    {
        return $this->hasMany(PuzzleCell::class);
    }

    public function connections()
    {
        return $this->hasMany(PuzzleConnection::class);
    }
}
