<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorUsage extends Model
{
    protected $fillable = ['user_id', 'calculator_id', 'inputs', 'result'];
    
    protected $casts = [
        'inputs' => 'array','result' => 'array',];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function calculator()
    {
        return $this->belongsTo(Calculator::class);
    }

    // In your Usage model
    public function getFormattedInputsAttribute()
    {
        if (empty($this->inputs)) {
            return 'N/A';
        }
        
        return is_array($this->inputs) 
            ? json_encode($this->inputs, JSON_PRETTY_PRINT)
            : $this->inputs;
    }

}
