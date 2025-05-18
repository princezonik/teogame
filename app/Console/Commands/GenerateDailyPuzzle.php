<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PuzzleGenerator;
use Illuminate\Support\Facades\Log;
use App\Models\Puzzle;
use Carbon\Carbon;

class GenerateDailyPuzzle extends Command
{
    protected $signature = 'puzzle:generate {date? : The date for the puzzle (YYYY-MM-DD, default tomorrow)} {--grid= : The grid size (default 5, minimum 3)}';
    protected $description = 'Generate a daily puzzle for the specified date with an optional grid size';

    protected $generator;

    public function __construct(PuzzleGenerator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    public function handle()
    {
        Log::info('Running puzzle:generate with arguments: ' . json_encode($this->arguments()));
        
        
        $dateInput = $this->argument('date');
        $gridSize = $this->option('grid') ? max(3, (int)$this->option('grid')) : 5; // Default 5, minimum 3

        Log::info('Parsed date input: ' . ($dateInput ?: 'null') . ', Grid size: ' . $gridSize);

        try {
            $date = $dateInput ? Carbon::parse($dateInput) : Carbon::tomorrow();
        } catch (\Exception $e) {
            Log::error('Invalid date format: ' . $e->getMessage());
            $this->error('Invalid date format: ' . $e->getMessage());
            return 1;
        }

        if (Puzzle::where('date', $date->toDateString())->exists()) {
            $this->info("Puzzle for {$date->toDateString()} already exists.");
            return 0;
        }

        $this->info("Generating puzzle for {$date->toDateString()} with grid size {$gridSize}...");

        try {
            $puzzle = $this->generator->generate($date, $gridSize);
            $this->info("Puzzle generated successfully: ID {$puzzle->id}");
            return 0;
        } catch (\Exception $e) {
            Log::error('Failed to generate puzzle: ' . $e->getMessage());
            $this->error("Failed to generate puzzle: {$e->getMessage()}");
            return 1;
        }
    }
}