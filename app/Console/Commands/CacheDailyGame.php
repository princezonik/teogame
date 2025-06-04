<?php

namespace App\Console\Commands;

use App\Services\DailyGameService;
use Illuminate\Console\Command;
use App\Services\PuzzleGenerator;

class CacheDailyGame extends Command
{
    protected $dailyGameService;
    protected $puzzleGenerator;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cache-daily-game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches the daily game at midnight';


    public function __construct(DailyGameService $dailyGameService, PuzzleGenerator $puzzleGenerator)
    {
        parent::__construct();
        $this->dailyGameService = $dailyGameService;
        $this->puzzleGenerator = $puzzleGenerator;
    }
    public function handle()
    {
         $games = $this->dailyGameService->getDailyGame();
        
        if ($games) {
            $this->info("Daily game cached: {$games->title}");
        } else {
            $this->error('No game available to cache.');
        }

        $date = now();        
        $gridSize = 5;    

        try {
            $puzzle = $this->puzzleGenerator->generate($date, $gridSize, $games);

            $this->info("Puzzle generated for '{$games->title}' on {$date->toDateString()} with ID {$puzzle->id}.");
        } catch (\Exception $e) {
            $this->error('Failed to generate puzzle: ' . $e->getMessage());
        }
    }
}
