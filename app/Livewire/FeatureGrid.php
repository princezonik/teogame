<?php

namespace App\Livewire;

use Livewire\Component;

class FeatureGrid extends Component
{

    public array $features = [
        [
            'title' => 'Catalog',
            'description' => 'Browse items with thumbnail images and narrow your search with filtering and sorting',
            'route' => 'catalog'
        ],
        [
            'title' => 'Players',
            'description' => 'Check your item inventory, value, and track your progress with our player history chart',
            'route' => 'players'
        ],
        [
            'title' => 'Games',
            'description' => 'Find in-depth Roblox game stats with Rolimon\'s game analytics',
            'route' => 'games'
        ],
        [
            'title' => 'Groups',
            'description' => 'Membership charts and other stats for Roblox groups',
            'route' => 'groups'
        ],
        // ... Add the rest similarly
    ];
  
    public function render()
    {
        return view('livewire.feature-grid');
    }
}
