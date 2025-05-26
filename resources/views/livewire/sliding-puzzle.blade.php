<div x-data x-init="window.slidingPuzzleWire = $wire" class="flex min-h-screen bg-gray-100 p-4">
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
                ⏱️ Time: <span id="time-counter" class="font-bold">0:00</span>
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
             style="width: fit-content; max-width: 90vw;">
            <!-- Tiles rendered by JS -->
        </div>

        <!-- Solved popup -->
        <div id="solved-popup"
             class="fixed top-0 left-0 w-full h-full bg-black/70 flex items-center justify-center hidden z-50">
            <div class="bg-white text-black p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-bold mb-4">🎉 Puzzle Solved!</h2>
                <button id="close-popup" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Play Again
                </button>
            </div>
        </div>
    </div>

    <!-- Leaderboard Aside -->
    {{-- <aside class="w-80 p-4 bg-gray-800 rounded-lg shadow-lg ml-4">
        <h2 class="text-2xl font-bold mb-4">Leaderboard</h2>
        <table id="leaderboard-table" class="w-full text-left">
            <thead>
                <tr>
                    <th class="p-2">Player</th>
                    <th class="p-2">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaderboard as $entry)
                    <tr>
                        <td class="p-2">{{ $entry['user_name'] }}</td>
                        <td class="p-2">{{ $entry['score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </aside> --}}

    
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
