<?php

namespace App\Livewire\Calculator;

use Livewire\Component;
use App\Models\FpsBenchmark;


class FpsBudgetEstimator extends Component
{

    public $gameTitle;
    public $cpuModel;
    public $gpuModel;
    public $resolution;
    public $averageFps;

    public function updated($property)
    {
        $this->lookupFps();
    }

    public function lookupFps()
    {
        if ($this->gameTitle && $this->cpuModel && $this->gpuModel && $this->resolution) {
            $match = FpsBenchmark::where('game_title', $this->gameTitle)
                ->where('cpu_model', $this->cpuModel)
                ->where('gpu_model', $this->gpuModel)
                ->where('resolution', $this->resolution)
                ->first();

            $this->averageFps = $match?->average_fps;
        } else {
            $this->averageFps = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.fps-budget-estimator');
    }
}
