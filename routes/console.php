<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
// use Illuminate\Console\Scheduling\Schedule;
use App\Services\PuzzleGenerator;
use Illuminate\Support\Facades\Log;
use App\Console\Commands\GenerateDailyPuzzle;
use App\Console\Commands\CacheDailyGame;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

       

//generate 5x5 Teogame freeflow like puzzle
Schedule::command(GenerateDailyPuzzle::class)
    ->dailyAt(0.00)
    ->timezone('UTC')
    ->onSuccess(fn() => Log::info('Daily puzzle job succeeded.'))
->onFailure(fn() => Log::error('Daily puzzle job failed.'));


//Daily game switcher
Schedule::command(CacheDailyGame::class)->dailyAt('00:00');