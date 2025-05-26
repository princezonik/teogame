<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'slug', 'description'];

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class, 'game_id', 'id');
    }

}
