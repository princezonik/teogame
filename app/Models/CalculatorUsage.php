<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorUsage extends Model
{
    protected $fillable = ['user_id', 'calculator_id', 'inputs', 'result'];
    
    protected $casts = [
        'inputs' => 'array',
        'result' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
