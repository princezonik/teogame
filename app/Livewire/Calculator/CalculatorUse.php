<?php

namespace App\Livewire\Calculator;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\CalculatorUsage;


class CalculatorUse extends Component
{

   public function calculate(){
        CalculatorUsage::create([
            'user_id' => Auth::id(), 
            'calculator_id' => $this->calculator->id, 
            'inputs' => $this->inputs, 
            // 'result' => $this->result, 
            // 'ip_address' => request()->ip(),
            // 'user_agent' => request()->userAgent(),
        ]);
   }
    public function render()
    {
        return view('livewire.calculator.calculator-use');
    }
}
