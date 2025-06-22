<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Calculator;

class CalculatorManager extends Component
{
    public $calculators;

    public function mount() {
        $this->calculators = Calculator::all();
    }
    public function render()
    {
        return view('livewire.admin.calculator-manager');
    }
}
