<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

class RobuxConverter extends Component
{
    public  $robux ;
    public  $usd;
    protected $rate = 0.0035;

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
        } else {
            $this->robux = '';
        }
    }
    

    public function render()
    {
        return view('livewire.calculator.robux-converter');
    }
}
