<?php

namespace App\Livewire\Calculator;

use Livewire\Component;

class PingFrameDelay extends Component
{

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
        } else {
            $this->missedFrames = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.ping-frame-delay');
    }
}
