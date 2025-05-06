<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public $activePage = 'dashboard';
    protected $listeners = ['setActivePage' => 'updateActivePage'];
    public $currentCalculator = null;
    public $showCalculatorMenu = false;


    public $showCalculators = false;
    public $selectedCalculator = null;

    public function toggleCalculators()
    {
        $this->showCalculators = !$this->showCalculators;
    }

    public function selectCalculator($calculator)
    {
        $this->selectedCalculator = $calculator;
        $this->dispatch('loadCalculator', $calculator);
    }

    public function toggleCalculatorMenu()
    {
        $this->showCalculatorMenu = !$this->showCalculatorMenu;
    }

    public function loadCalculator($componentName)
    {
        $this->currentCalculator =  $componentName;
    }


    public function updateActivePage($page)
    {
        $this->activePage = $page;
        $this->dispatch('loadPage', $page);
    }

    public function render()
    {
        return view('livewire.sidebar');
    }
}
