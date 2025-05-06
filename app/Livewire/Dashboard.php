<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $page = 'dashboard';
    
    protected $listeners = ['loadPage' => 'setPage'];

    public $activePage = 'dashboard';
    
    public $currentCalculator = null;

    public function loadCalculator($calculator)
    {
        $this->currentCalculator = $calculator;
    }
    public function setPage($page)
    {
        $this->page = $page;
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
