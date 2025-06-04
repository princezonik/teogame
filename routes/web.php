<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ToolController;
use App\Livewire\ToolCalculator;
use App\Livewire\HomePage;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CalculatorController;


Route::get('/', HomePage::class)->name('home');


Route::get('/register', [RegisteredUserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('calculators', CalculatorController::class);
Route::get('/calculator/{slug}', [CalculatorController::class, 'show'])->name('calculator.show');


//Auth middleware

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/submit-score', function(){ 
        return view('submit-score');
    })->name('scores.create');
});
    
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



Route::prefix('admin')->name('admin.')->group(function () {
    // Show login form
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    
    // Handle login
    Route::post('/login', [AdminAuthController::class, 'login']);
    
    // Register
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register']);
    
    // Admin dashboard (after login)
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    });
});



// Group all API routes
// Route::prefix('api')->group(function () {

// });

require __DIR__.'/auth.php';
