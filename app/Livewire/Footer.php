<?php

namespace App\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public $description = 'Daily logic puzzles and gaming calculators made for gamers.';
    public $supportEmail = 'support@teogame.com';
    public $links = [
        'Home' => '/',
        'Daily Puzzle' => '/puzzle',
        'Calculators' => '/calculators',
        'Leaderboard' => '/leaderboard',
    ];

    
    public function render()
    {
        return view('livewire.footer');
    }
}
