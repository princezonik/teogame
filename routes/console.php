<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
// use Illuminate\Console\Scheduling\Schedule;
use App\Services\PuzzleGenerator;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 1) Define the Artisan command
Artisan::command('puzzle:generate', function () {
    $generator = new PuzzleGenerator();
    $puzzle   = $generator->generate(5, 3);
    $this->info("Generated puzzle #{$puzzle->id}");
})->describe('Generate the daily Path‑Connect puzzle');

// 2) Schedule it at midnight UTC
Schedule::command('app:generate-daily-puzzle')
        ->everyMinute()
        ->timezone('UTC')
        ->onSuccess(fn() => Log::info('Daily puzzle job succeeded.'))
        ->onFailure(fn() => Log::error('Daily puzzle job failed.'));

// Schedule::command('puzzle:generate')
//     ->dailyAt('00:00')
//     ->timezone('UTC');


// Schedule::command('puzzle:generate')->everyMinute();
