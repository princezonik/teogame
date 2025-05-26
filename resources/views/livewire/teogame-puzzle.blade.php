<div class="max-w-2xl mx-auto p-4">
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }} 
        </div>
    @endif


     <!-- Moves counter -->
    <div class="flex justify-between items-center mb-4">
        <div class="text-lg font-semibold">
            Moves: <span x-text="moves" class="text-blue-600"></span>
        </div>
        
        <template x-if="bestMoves !== null">
            <div class="text-lg font-semibold">
                Best: <span x-text="bestMoves" class="text-green-600"></span>
            </div>
        </template>
    </div>

   
    @if ($puzzle)
        <div wire:ignore.self>
            <div x-data="puzzleBoard({
                {{-- gridSize: {{ $gridSize ?? 5 }}, --}}
                cells: @js($cells),
                connections: @js($connections),
                userPaths: @js((object)$userPaths),
                isCompleted: {{ $isCompleted ? 'true' : 'false' }}
            })" x-init="init()" 
           
               
                <!-- SVG Grid -->
                <svg :width="gridSize * 50 + 2" :height="gridSize * 50 + 2" class="border border-gray-300 mx-auto">
                    <!-- Grid Lines -->
                    <g class="stroke-gray-300 stroke-1">
                        @for ($i = 0; $i <= $gridSize; $i++)
                            <line x1="{{ $i * 50 + 1 }}" y1="1" x2="{{ $i * 50 + 1 }}" y2="{{ $gridSize * 50 + 1 }}"></line>
                            <line x1="1" y1="{{ $i * 50 + 1 }}" x2="{{ $gridSize * 50 + 1 }}" y2="{{ $i * 50 + 1 }}"></line>
                        @endfor
                    </g>

                    <!-- Paths Group - Rendered by Alpine -->
                    <g x-ref="pathsGroup"></g>

                    <!-- Cells Group - Rendered by Alpine -->
                    <g x-ref="cellsGroup"></g>
                </svg>

                <!-- Success Message -->
                {{-- <div x-show="isCompleted" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-500">
                    <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg animate-bounce">
                        <h2 class="text-2xl font-bold">Congratulations!</h2>
                        <p>You've completed the puzzle!</p>
                        <button @click="resetPuzzle()" class="mt-4 bg-white text-green-500 px-4 py-2 rounded hover:bg-gray-100">
                            Play Again
                        </button>
                    </div>
                </div> --}}

                

                <!-- Controls -->
                <div class="mt-4 flex justify-center">
                    <button @click="resetPuzzle()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    @else
        <p class="text-center text-gray-500">No puzzle found for {{ $date }}.</p>
    @endif
</div>
@push('scripts') <script src="{{ asset('js/teogame-puzzle.js')}}"> </script> @endpush

@push('styles')
    <style>

        .endpoint {
            pointer-events: all;
            z-index: 10;
        },
        

        .path-segment {
            transition: all 0.1s ease;
        },

        svg {
            user-select: none;
            -webkit-user-select: none;
        },
        .animate-bounce {
            animation: bounce 1s ease-in-out;
        },
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style> 
@endpush