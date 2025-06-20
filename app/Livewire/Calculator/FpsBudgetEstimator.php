<?php

namespace App\Livewire\Calculator;

use App\Models\Calculator;
use App\Models\CalculatorUsage;
use Livewire\Component;
use App\Models\FpsBenchmark;
use Illuminate\Support\Facades\Auth;

class FpsBudgetEstimator extends Component
{

    public $gameTitle;
    public $cpuModel;
    public $gpuModel;
    public $resolution;
    public $averageFps;
    public $calculatorId;

    public function mount()
    {
        // Cache the calculator ID once
        $this->calculatorId = Calculator::where('slug', 'fps-budget-estimator')->value('id');
    }
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

            if ($match) {
                $this->averageFps = $match->average_fps;

                // Save usage - only when a match is found
                CalculatorUsage::create([
                    'user_id' => Auth::id(),
                    'calculator_id' => $this->calculatorId,
                    'inputs' => [
                        'gameTitle' => $this->gameTitle,
                        'cpuModel' => $this->cpuModel,
                        'gpuModel' => $this->gpuModel,
                        'resolution' => $this->resolution,
                    ],
                    'result' => ['averageFps' => $this->averageFps],
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            } else {
                $this->averageFps = null;
            }
        } else {
            $this->averageFps = null;
        }
    }
    public function render()
    {
        return view('livewire.calculator.fps-budget-estimator');
    }
}
