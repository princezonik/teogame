<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectricityCost extends Model
{
    protected $fillable = [
        'wattage',
        'rate_per_kwh',
        'hours_per_day',
        'cost_per_hour',
        'cost_per_day',
        'cost_per_month',
    ];
}
