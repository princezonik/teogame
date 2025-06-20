<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        
        // $googleUser = Socialite::driver('google')->stateless()->user();
        $googleUser = Socialite::driver('google')->user();
       
        
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(str()->random(16)), // Random placeholder
            ]
        );

        Auth::login($user);

        return redirect()->route('dashboard'); // Or leaderboard page
    }
}
