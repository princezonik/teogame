<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calculator extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'description'];

    protected $casts = [
        'updated_at' => 'datetime',
        'settings' => 'array'
    ];

    public function usages()
    {
        return $this->hasMany(CalculatorUsage::class);
    }

}
