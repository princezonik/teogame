<div x-data="puzzleBoard({
        gridSize: {{ $gridSize ?? 5 }},
        cells: @js($cells),
        connections: @js($connections),
        userPaths: @js((object)$userPaths),
        isCompleted: @js($isCompleted),
        moves: {{ $moves }},
        bestMoves: {{ $bestMoves ?? 'null' }},
        bestMovesFromServer: @js($bestMoves),
        isAuth: @js(auth()->check())
        
       
        
    })"
     x-init="init('{{ $game->id }}')" 
     class="max-w-2xl mx-auto p-4">

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Moves and Best Moves -->
    <div class="flex justify-between items-center mb-4">
        <div class="text-lg font-semibold">
            Moves: <span x-text="moves" class="text-blue-600"></span>
        </div>
        <div x-show="bestMoves !== null" class="text-lg font-semibold">
            Best: <span x-text="bestMoves" class="text-green-600" x-bind:class="{'animate-pulse': newBest}"></span>
        </div>
    </div>

    @if ($puzzle)
        <div  class="relative inline-block">

            <!-- SVG Grid -->
            <svg :width="gridSize * 50 + 2" :height="gridSize * 50 + 2" class="border border-gray-300 mx-auto">
                <!-- Grid Lines -->
                <g class="stroke-gray-300 stroke-1">
                    @for ($i = 0; $i <= $gridSize; $i++)
                        <line x1="{{ $i * 50 + 1 }}" y1="1" x2="{{ $i * 50 + 1 }}" y2="{{ $gridSize * 50 + 1 }}"></line>
                        <line x1="1" y1="{{ $i * 50 + 1 }}" x2="{{ $gridSize * 50 + 1 }}" y2="{{ $i * 50 + 1 }}"></line>
                    @endfor
                </g>

                <!-- Paths Group -->
                <g x-ref="pathsGroup"></g>

                <!-- Cells Group -->
                <g x-ref="cellsGroup"></g>
            </svg>

            <!-- Completion Popup -->
            <div x-show="isCompleted" x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute top-0 left-0 w-full h-full bg-[#192440] bg-opacity-95 text-white p-6 rounded shadow-lg flex flex-col justify-center items-center z-20">
                <h2 class="text-2xl font-bold mb-2">Flow Complete!</h2>
                <p class="mb-1">Moves: <span x-text="moves"></span></p>
                <p class="mb-1">Best Moves: <span x-text="bestMoves ?? 'N/A'"></span></p>
                <p class="mb-3">Score: <span x-text="score ?? 'N/A'"></span></p>
                <button x-on:click="resetPuzzle()" class="bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">
                    Start New Game
                </button>
            </div>

        </div>

        <!-- Controls -->
        <div class="mt-4 flex justify-center gap-4">
            <button x-on:click="resetPuzzle()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Reset
            </button>
        </div>
    @else
        <p class="text-center text-gray-500">No puzzle found for {{ $date }}.</p>
    @endif
</div>


@push('styles')
    <style>
        .endpoint {
            pointer-events: all;
            z-index: 10;
        }
        
        .path-segment {
            transition: all 0.1s ease;
        }
        
        svg {
            user-select: none;
            -webkit-user-select: none;
            touch-action: none;
        }

        .animate-pulse {
            animation: pulse 1s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        </style>
@endpush

@push('scripts')
    <script>
        window.gameId = {{ $game->id }}; // Should Not be null when echo initializes
        window.isAuthenticated = @json(Auth()->check());
        window.bestMovesFromServer = @json($bestMoves ?? null);
       
    </script>
    <script src="{{ asset('js/teogame-puzzle.js') }}"></script>
@endpush