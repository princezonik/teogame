<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attempt;
use App\Models\Puzzle;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PlayPuzzle extends Component
{
    public $puzzle = null;
    public $error = null;

    public function mount()
    {
        $this->loadPuzzle();
    }

    public function loadPuzzle()
    {
        try {
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get(url('/api/puzzle/today'));

            if ($response->failed()) {
                $this->error = 'Failed to load puzzle: ' . ($response->json('error') ?? 'Unknown error');
                $this->puzzle = ['grid_size' => 5, 'cells' => [], 'connections' => []]; // Fallback
                return;
            }

            $data = $response->json();
            if (!isset($data['puzzle']['grid_size']) || !isset($data['puzzle']['cells']) || !isset($data['puzzle']['connections'])) {
                $this->error = 'Invalid puzzle data structure';
                $this->puzzle = ['grid_size' => 5, 'cells' => [], 'connections' => []]; // Fallback
                return;
            }

            $this->puzzle = $data['puzzle'];
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'Error loading puzzle: ' . $e->getMessage();
            $this->puzzle = ['grid_size' => 5, 'cells' => [], 'connections' => []]; // Fallback
        }
    }

    public function render()
    {
        return view('livewire.play-puzzle', [
            'puzzle' => $this->puzzle,
            'error' => $this->error,
        ]);
    }
}