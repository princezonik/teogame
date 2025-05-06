<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CraftingDecision extends Model
{
    protected $fillable = [
        'material_cost',
        'market_price',
        'roi_percentage',
        'recommendation',
    ];
}
