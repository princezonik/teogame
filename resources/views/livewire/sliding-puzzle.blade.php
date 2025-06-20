<div x-data x-init="window.slidingPuzzleWire = $wire" wire:ignore  class="flex  ">
    <!-- Main Game Area -->
    <div class="flex-1 flex flex-col items-center justify-center">
        <h1 class="text-3xl font-bold mb-6">Sliding Puzzle</h1>

        <div class="mb-4">
            <label for="difficulty" class="mr-2">Difficulty:</label>
            <select id="difficulty" class="text-black p-2 rounded">
                <option value="3">3 x 3</option>
                <option value="4">4 x 4</option>
                <option value="5">5 x 5</option>
            </select>
        </div>

        <div class="mb-4 flex items-center gap-6">
            <div class="text-lg">
                🧮 Moves: <span id="move-counter" class="font-bold">0</span>
            </div>
            <div class="text-lg">
                ⏱️ Time: <span id="time-counter" class="font-bold">00:00</span>
            </div>
            <div class="text-lg">
                🏆 Best Moves: <span id="best-moves-counter" class="font-bold">{{ $bestMoves ?? 'N/A' }}</span>
            </div>
        </div>

        <button id="start-game" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Start Game
        </button>

        <div id="puzzle-grid"
             class="grid gap-2 p-4 rounded-2xl shadow-lg bg-cyan-700 transition-all duration-300"
             style="width: fit-content; max-width: 90vw;"
             wire:ignore >
            <!-- Tiles rendered by JS -->
        </div>

        <!-- Solved popup -->
        <div id="solved-popup" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-[#0e7490] p-6 rounded shadow-md text-center">
                <h2 class="text-xl font-bold mb-4">🎉 Congrats! You solved the puzzle!</h2>
                <p>Moves: <span class="moves"></span></p>
                <p>Time: <span class="time"></span></p>
                <p>Best Moves: <span class="best-moves"></span></p>
                <button id="close-popup" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>

    </div>


    
</div>

@push('styles')
    <style>
        #puzzle-grid {
            display: grid;
        }

        .tile {
            width: 80px;
            height: 80px;
            font-size: 2rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            box-shadow: inset -2px -2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.2s;
        }

        .tile:not(.empty):hover {
            cursor: pointer;
            transform: scale(1.05);
        }

        .tile.empty {
            background-color: #12828f;
            box-shadow: none;
        }

        .tile {
            color: black;
            font-family: sans-serif;
        }

        .tile[data-value="1"],
        .tile[data-value="2"],
        .tile[data-value="3"],
        .tile[data-value="4"] {
            background-color: #f00;
        }

        .tile[data-value="5"],
        .tile[data-value="6"],
        .tile[data-value="7"],
        .tile[data-value="8"],
        .tile[data-value="9"],
        .tile[data-value="10"],
        .tile[data-value="11"],
        .tile[data-value="12"],
        .tile[data-value="13"],
        .tile[data-value="14"],
        .tile[data-value="15"] {
            background-color: #f90;
        }

        #leaderboard-table {
            border-collapse: collapse;
        }

        #leaderboard-table th, #leaderboard-table td {
            border: 1px solid #4a5568;
            padding: 8px;
        }
    </style>
@endpush

@push('scripts')



    <script>
        window.gameId = {{ $game->id }}; // Should Not be null when echo initializes
        window.isAuthenticated = @json(auth()->check());
        window.difficultyLevel = 3; // Default difficulty
        </script>

    <script>
        document.addEventListener('livewire:initialized', function () {
            console.log('Livewire initialized');
            Livewire.on('show-error', (event) => {
                alert(event.message);
            });
            Livewire.on('update-best-moves', (event) => {
                document.getElementById('best-moves-counter').textContent = event.bestMoves ?? 'N/A';
            });
        });
    </script>

<script src="{{ asset('js/slidingPuzzle.js') }}"></script>
@endpush
