<?php

namespace App\Livewire\Admin\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Login extends Component
{
    public $email, $password;

    public function login()
    {
       
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
           
            if (Auth::user()->role === 'admin') {
                Log::info('hello');
               $user = Auth::user();
              
                return redirect()->intended('/admin/dashboard');
            } else {
                Auth::logout();
                session()->flash('error', 'You are not authorized as an admin.');
                return;
            }
        }

        session()->flash('error', 'Invalid login credentials.');
    }

    public function render()
    {
        return view('livewire.admin.auth.login')->layout('layouts.admin.guest');
    }
}
