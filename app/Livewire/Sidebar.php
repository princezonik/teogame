<?php

namespace App\Livewire;

use App\Models\Calculator;
use Livewire\Component;

class Sidebar extends Component
{
    public $calculators;
    public $activeCalculator = null;
 

    public function mount()
    {
        logger('Loading calculators...');
        $this->calculators = Calculator::where('is_visible', true)->get();
    }

    public function toggleCalculator($id)
    {
        
        $this->activeCalculator = $this->activeCalculator === $id ? null : $id;
    }

    

   
    public function render()
    {
        
        return view('livewire.sidebar', ['calculators' => $this->calculators, 'activeCalculator' => $this->activeCalculator]);
    }
}
