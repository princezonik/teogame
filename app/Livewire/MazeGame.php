<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class MazeGame extends Component
{
    public $difficulty = 'easy';
    public $maze = [];
    public $playerX = 1;
    public $playerY = 1;
    public $exitX;
    public $exitY;
    public $moves = 0;
    public $gameState = 'select'; // select, playing, won
    public $width;
    public $height;

    protected $listeners = ['movePlayer'];

    public function mount()
    {
        $this->resetGame();
    }

    public function resetGame()
    {
        $this->gameState = 'select';
        $this->moves = 0;
        $this->maze = [];
        $this->playerX = 1;
        $this->playerY = 1;
    }

    public function startGame()
    {
       try {
        Log::info('Starting game', ['difficulty' => $this->difficulty]);
        $this->width = 5;
        $this->height = 5;
        $this->maze = [
            [1, 1, 1, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 0, 1, 1],
            [1, 0, 0, 0, 1],
            [1, 1, 1, 3, 1],
        ];
        $this->playerX = 1;
        $this->playerY = 1;
        $this->maze[$this->playerY][$this->playerX] = 2; // Player
        $this->exitX = 3;
        $this->exitY = 4;
        $this->moves = 0;
        $this->gameState === 'playing';
        Log::info('Game started', ['gameState' => $this->gameState, 'maze' => $this->maze]);
    } catch (\Exception $e) {
        Log::error('Error in startGame', ['error' => $e->getMessage()]);
        $this->gameState = 'select';
    }
    }

    private function setMazeSize()
    {
        Log::info('Setting maze size', ['difficulty' => $this->difficulty]);
        switch ($this->difficulty) {
            case 'easy':
                $this->width = 5;
                $this->height = 5;
                break;
            case 'medium':
                $this->width = 10;
                $this->height = 10;
                break;
            case 'hard':
                $this->width = 15;
                $this->height = 15;
                break;
            default:
                Log::error('Invalid difficulty', ['difficulty' => $this->difficulty]);
                $this->width = 5;
                $this->height = 5;
        }
    }

    private function generateMaze()
    {
        // Initialize maze with walls (1)
        $this->maze = array_fill(0, $this->height, array_fill(0, $this->width, 1));

        // Start DFS from (1,1)
        $this->dfs(1, 1);

        // Ensure player start position is a path
        $this->maze[1][1] = 0;

        Log::info('Maze generated', ['maze' => $this->maze]);
    }

    private function dfs($x, $y)
    {
        $this->maze[$y][$x] = 0; // Mark as path
        Log::info('DFS visiting', ['x' => $x, 'y' => $y]);

        $directions = [[0, 2], [2, 0], [0, -2], [-2, 0]]; // Right, Down, Left, Up
        shuffle($directions);

        foreach ($directions as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;

            if ($nx >= 0 && $nx < $this->width && $ny >= 0 && $ny < $this->height && $this->maze[$ny][$nx] == 1) {
                // Carve path
                $this->maze[$y + $dy / 2][$x + $dx / 2] = 0;
                Log::info('Carving path', ['nx' => $nx, 'ny' => $ny]);
                $this->dfs($nx, $ny);
            }
        }
    }

    private function placeExit()
    {
        // Place exit on the right or bottom edge
        if (rand(0, 1) == 0) {
            // Right edge
            $this->exitX = $this->width - 2;
            $this->exitY = rand(1, $this->height - 2);
            while ($this->maze[$this->exitY][$this->exitX] == 1) {
                $this->exitY = rand(1, $this->height - 2);
            }
        } else {
            // Bottom edge
            $this->exitX = rand(1, $this->width - 2);
            $this->exitY = $this->height - 2;
            while ($this->maze[$this->exitY][$this->exitX] == 1) {
                $this->exitX = rand(1, $this->width - 2);
            }
        }
        $this->maze[$this->exitY][$this->exitX] = 3; // Exit
        Log::info('Exit placed', ['exitX' => $this->exitX, 'exitY' => $this->exitY]);
    }

    public function movePlayer($direction)
    {
        if ($this->gameState !== 'playing') {
            return;
        }

        $newX = $this->playerX;
        $newY = $this->playerY;

        if ($direction === 'up') {
            $newY--;
        } elseif ($direction === 'down') {
            $newY++;
        } elseif ($direction === 'left') {
            $newX--;
        } elseif ($direction === 'right') {
            $newX++;
        }

        // Check boundaries and walls
        if ($newX >= 0 && $newX < $this->width && $newY >= 0 && $newY < $this->height && $this->maze[$newY][$newX] != 1) {
            $this->maze[$this->playerY][$this->playerX] = 0; // Clear old position
            $this->playerX = $newX;
            $this->playerY = $newY;
            $this->moves++;

            if ($this->maze[$newY][$newX] == 3) {
                $this->gameState = 'won';
            } else {
                $this->maze[$newY][$newX] = 2; // New player position
            }
        }
    }

    public function render()
    {
        Log::info('Rendering', ['gameState' => $this->gameState , 'maze' => $this->maze]);
        return view('livewire.maze-game');
    }
}