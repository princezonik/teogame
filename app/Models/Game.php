<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'slug', 'description'];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function puzzles()
    {
        return $this->hasMany(Puzzle::class);
    }

}
