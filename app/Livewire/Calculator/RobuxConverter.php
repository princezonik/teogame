<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;


class RobuxConverter extends Component
{
    public  $robux ;
    public  $usd;
    protected $rate = 0.0035;

    public $calculatorId;

    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'robux-converter')->value('id');
    }

    public function updatedRobux($value)
    {
        if (is_numeric($value)) {
         
            $this->usd = $value * $this->rate;
        } else {
            $this->usd = null;
        }
    }

    public function updatedUsd($value)
    {
        if (is_numeric($value)) {
            $this->robux = number_format($value / $this->rate, 2);
            $this->logUsage();
        } else {
            $this->robux = '';
        }
    }

    private function logUsage()
    {
        CalculatorUsage::create([
            'user_id' => Auth::id(),  // null if guest
            'calculator_id' => $this->calculatorId,
            'inputs' => [
                'robux' => $this->robux,
                'usd' => $this->usd,
            ],
            'result' => [
                'robux' => $this->robux,
                'usd' => $this->usd,
            ],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    

    public function render()
    {
        return view('livewire.calculator.robux-converter');
    }
}
