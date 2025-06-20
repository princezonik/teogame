<?php

namespace App\Livewire\Admin\Partials;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $items = [];

    public function mount($items = [])
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('livewire.admin.partials.breadcrumb');
    }
}
