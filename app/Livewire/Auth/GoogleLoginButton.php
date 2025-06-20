<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class GoogleLoginButton extends Component
{
   public function render()
    {
        return view('livewire.auth.google-login-button');
    }
    
    public function redirectToGoogle()
    {
        return redirect()->route('google.login');
    }
}
