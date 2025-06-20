<?php

namespace App\Livewire\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DpsTtkCalculator extends Component
{
    public $dps;
    public $enemyHp;
    public $ttk;
    public $calculatorId;

    public function updated($property)
    {
        $this->calculateTtk();
    }

    public function calculateTtk()
    {
        $this->calculatorId = Calculator::where('slug', 'dps-ttk-calculator' )->first();
        $calcId = $this->calculatorId->id;
        
        if (is_numeric($this->dps) && is_numeric($this->enemyHp) && $this->dps > 0) {
            $this->ttk = round($this->enemyHp / $this->dps, 2);

            
            CalculatorUsage::create([
                'user_id' => Auth::id(),
                'calculator_id' => $calcId,
                'inputs' => [
                    'dps' => $this->dps,
                    'enemyHp' => $this->enemyHp,
                ],
                'result' => ['ttk' => $this->ttk],
                
            ]);
        } else {
            $this->ttk = null;
        }
    }

    public function render()
    {
        return view('livewire.calculator.dps-ttk-calculator');
    }
}
