<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConverterController;
use App\Http\Controllers\TtkCalculatorController;
use App\Http\Controllers\LootDropSimulatorController;
use App\Http\Controllers\SteamBacklogController;
use App\Http\Controllers\FpsBenchmarkController;
use App\Http\Controllers\ExpCalculatorController;
use App\Http\Controllers\SpriteCostEstimatorController;
use App\Http\Controllers\VramCheckController;
use App\Http\Controllers\CraftingDecisionController;
use App\Http\Controllers\ElectricityCostController;
use App\Http\Controllers\TwitchRevenueEstimatorController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ToolController;
use App\Livewire\ToolCalculator;
use App\Livewire\HomePage;
use App\Http\Controllers\Api\PuzzleController;
use App\Http\Controllers\Auth\AuthController;

use App\Livewire\TeoGame;
use App\Livewire\PuzzleDisplay;
use App\Http\Controllers\Api\AttemptController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ScoreController;

Route::get('/', HomePage::class)->name('home');


Route::get('/register', [RegisteredUserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::post('/scores', [ScoreController::class, 'store'])->name('scores.store');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::post('/leaderboard/refresh', [LeaderboardController::class, 'refresh'])->name('leaderboard.refresh');
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



Route::get('/catalog', fn () => view('pages.catalog'))->name('catalog');
Route::get('/players', fn () => view('pages.players'))->name('players');
Route::get('/games', fn () => view('pages.games'))->name('games');
Route::get('/groups', fn () => view('pages.groups'))->name('groups');


// Route::get('/dashboard', function () { 
//     return view('dashboard'); 
// })->middleware(['auth', 'verified'])->name('dashboard');
   


// Route::get('/game', \App\Livewire\Game2048::class);

Route::get('/tools/{slug}', ToolCalculator::class)->name('tools.show');



Route::post('/submit-attempt', [AttemptController::class, 'store'])->name('submit-attempt');

// Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
// Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



Route::prefix('tools')->group(function () {
    
    Route::get('/robux-usd', [ConverterController::class, 'showForm']);
    Route::post('/robux-usd', [ConverterController::class, 'convert'])->name('convert');
    
    Route::get('/ttk', [TtkCalculatorController::class, 'showForm']);
    Route::post('/ttk', [TtkCalculatorController::class, 'calculate'])->name('ttk.calculate');
    
    Route::get('/lootdrop_simulator', [LootDropSimulatorController::class, 'showForm']);
    Route::post('/lootdrop/calculate', [LootDropSimulatorController::class, 'calculate'])->name('lootdrop.calculate');
    
    Route::get('/steam-backlog', [SteamBacklogController::class, 'showForm'])->name('steam_backlog.form');
    Route::post('/steam-backlog/calculate', [SteamBacklogController::class, 'calculateBacklog'])->name('steam_backlog.calculate');
    
    Route::get('/estimate-fps', [FpsBenchmarkController::class, 'estimate']);
    
    Route::get('/exp-calculator', [ExpCalculatorController::class, 'showForm'])->name('exp.form');
    Route::post('/exp-calculator', [ExpCalculatorController::class, 'calculate'])->name('exp.calculate');
    
    Route::get('/sprite-cost-estimator', [SpriteCostEstimatorController::class, 'show'])->name('sprite.form');
    Route::post('/sprite-cost-estimator', [SpriteCostEstimatorController::class, 'estimate'])->name('sprite.estimate');
    
    Route::get('/vram-checker', [VramCheckController::class, 'showForm'])->name('vram.form');
    Route::post('/vram-checker', [VramCheckController::class, 'check'])->name('vram.check');
    
    Route::get('/craft-roi', [CraftingDecisionController::class, 'showForm'])->name('craft.form');
    Route::post('/craft-roi', [CraftingDecisionController::class, 'calculate'])->name('craft.calculate');
    
    Route::get('/electricity-cost', [ElectricityCostController::class, 'showForm'])->name('electricity.form');
    Route::post('/electricity-cost', [ElectricityCostController::class, 'calculate'])->name('electricity.calculate');
    
    
    Route::get('/twitch-revenue', [TwitchRevenueEstimatorController::class, 'show'])->name('twitch.form');
    Route::post('/twitch-revenue', [TwitchRevenueEstimatorController::class, 'estimate'])->name('twitch.estimate');

});


// Group all API routes
Route::prefix('api')->group(function () {
    
    // Fetch today's puzzle
    Route::get('/puzzle/today', [PuzzleController::class, 'today']);
    Route::post('/attempts', [AttemptController::class, 'store']);

});



Route::get('/tools', [ToolController::class, 'index']);

 

require __DIR__.'/auth.php';
