<?php

namespace App\Livewire;

use App\Models\Calculator;
use Livewire\Component;
use Livewire\Attributes\Layout;

// #[Layout('layouts.guest')]

class HomePage extends Component
{
        public $calculators;
    public $activeCalculator = null;
    public $selectedCalculator = null;

    public function mount()
    {
        $this->calculators = Calculator::where('is_visible', true)->get();
    }

    public function toggleCalculator($calculatorId)
    {
        $this->activeCalculator = $this->activeCalculator === $calculatorId ? null : $calculatorId;
    }

    public function showCalculator($id)
    {
        $this->selectedCalculator = Calculator::find($id);
    }

    public function openCalculator($slug)
    {
        // $this->activeCalculator = Calculator::where('slug', $slug)->first();
        $this->activeCalculator = $slug;
    }

    public function goBack()
    {
        $this->selectedCalculator = null;
    }

 

    public function redirectToLogin(){
        
        return redirect()->route('login');
    }
    
    public function render()
    {    
        return view('livewire.home-page', ['calculators' => Calculator::all()]);
    }
}
