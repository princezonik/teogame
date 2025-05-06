<?php

namespace App\Livewire;

use Livewire\Component;

class HomePage extends Component
{

    public function redirectToLogin(){
        
        return redirect()->route('login');
    }
    
    public function render()
    {    
        return view('livewire.home-page');
    }
}
