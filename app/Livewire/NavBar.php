<?php

namespace App\Livewire;

use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavBar extends Component
{
    public $calculators;
    public $activeCalculator = null;
 

    public function mount()
    {
        $this->calculators = Calculator::where('is_visible', true)->get();
    }

    public function toggleCalculator($id)
    {
        $calculator = Calculator::findOrFail($id);
        
     
        if($calculator) { 
            $this->activeCalculator = [
                'id' => $calculator->id, 
                'title' => $calculator->title, 
                'slug' => $calculator->slug,  
                'description' => $calculator->description
            ];

           
        }
    }


    public function backToList(){
        $this->activeCalculator = null;
    }
    public function render()
    {
        return view('livewire.nav-bar');
    }
}
