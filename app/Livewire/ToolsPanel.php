<?php

namespace App\Livewire;

use Livewire\Component;

class ToolsPanel extends Component
{

    public $currentCalculator = null;

    protected $listeners = ['loadCalculator'];

    public function loadCalculator($calculator)
    {
        $this->currentCalculator = $calculator;
    }


    public function render()
    {
        return view('livewire.tools-panel');
    }
}
