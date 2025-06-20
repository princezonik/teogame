<?php

namespace App\Livewire\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ExpToLevel extends Component
{

    public $currentLevel;
    public $currentExp;
    public $targetLevel;
    public $expNeeded;
    public $calculatorId;

    public function updated($property)
    {
        $this->calculateExpNeeded();
    }

    // Standard curve: EXP to reach level n = 100 * n^2
    public function totalExpToLevel($level): int
    {
        return 100 * $level * $level;
    }

    public function calculateExpNeeded()
    {
        $this->calculatorId = Calculator::where('slug', 'exp-to-level' )->first();
        $calcId = $this->calculatorId->id;
        if (is_numeric($this->currentLevel) && is_numeric($this->targetLevel) &&
            is_numeric($this->currentExp) && $this->targetLevel > $this->currentLevel) {

            $totalExpTarget = $this->totalExpToLevel($this->targetLevel);
            $totalExpCurrent = $this->totalExpToLevel($this->currentLevel) + $this->currentExp;

            $this->expNeeded = max(0, $totalExpTarget - $totalExpCurrent);

            CalculatorUsage::create([
                'user_id' => Auth::id(),
                'calculator_id' => $calcId,
                'inputs' => [
                    'currentLevel' => $this->currentLevel,
                    'currentExp' => $this->currentExp,
                    'targetLevel' => $this->targetLevel,
                ],
                'result' => [
                    'expNeeded' => $this->expNeeded,
                ],
                
            ]);
        } else {
            $this->expNeeded = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.exp-to-level');
    }
}
