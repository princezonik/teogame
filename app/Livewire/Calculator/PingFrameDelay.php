<?php

namespace App\Livewire\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PingFrameDelay extends Component
{
    public $calculatorId;
    public function mount()
    {
        $this->calculatorId = Calculator::where('slug', 'ping-frame-delay')->value('id');
    }

    public $pingMs;
    public $frameRate = 60; // Default FPS
    public $missedFrames;

    public function updated($property)
    {
        $this->calculateDelay();
    }

    public function calculateDelay()
    {
        if (is_numeric($this->pingMs) && is_numeric($this->frameRate) && $this->frameRate > 0) {
            $frameTime = 1000 / $this->frameRate; // ms per frame
            $this->missedFrames = floor($this->pingMs / $frameTime);

            CalculatorUsage::create([
                'user_id' => Auth::id(),
                'calculator_id' => $this->calculatorId,
                'inputs' => [
                    'pingMs' => $this->pingMs,
                    'frameRate' => $this->frameRate,
                ],
                'result' => ['missedFrames' => $this->missedFrames],
               
            ]);
        } else {
            $this->missedFrames = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.ping-frame-delay');
    }
}
