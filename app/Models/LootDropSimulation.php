<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class LootDropSimulation extends Model
{

    protected $fillable = [
        'probability',
        'pulls',
        'loot_drop_chance',
    ];
}
