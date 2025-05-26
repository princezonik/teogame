<?php

namespace App\Console\Commands;

use App\Services\DailyGameService;
use Illuminate\Console\Command;

class CacheDailyGame extends Command
{
    protected $dailyGameService;
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


    public function __construct(DailyGameService $dailyGameService)
    {
        parent::__construct();
        $this->dailyGameService = $dailyGameService;
    }
    public function handle()
    {
         $games = $this->dailyGameService->getDailyGame();
        
        if ($games) {
            $this->info("Daily game cached: {$games->title}");
        } else {
            $this->error('No game available to cache.');
        }
    }
}
