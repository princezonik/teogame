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
use App\Livewire\Admin\Auth\Auth;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Calculators\Calculators;
use App\Livewire\Admin\Calculators\UsageHistory;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Leaderboard;
use App\Livewire\Admin\PuzzleManager;

Route::get('/', HomePage::class)->middleware('guest')->name('home');


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


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/admin/login', Login::class)->name('admin.login');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');

    Route::get('/calculators', Calculators::class)->name('admin.calculators');
    Route::get('/usage-history', UsageHistory::class)->name('admin.usage.history');
    Route::get('/leaderboard', Leaderboard::class)->name('admin.leaderboard');
    Route::get('/manage-puzzles', PuzzleManager::class)->name('admin.manage.puzzle');

    Route::post('/logout', [AdminAuthController::class, 'logout']);

    
});



// Group all API routes
// Route::prefix('api')->group(function () {

// });

require __DIR__.'/auth.php';
