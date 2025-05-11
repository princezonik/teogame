<div wire:key="{{ $gameState }}" x-data="{ direction: '' }" 
     x-on:keydown.window="['w', 'ArrowUp'].includes($event.key) ? direction = 'up' : 
                        ['s', 'ArrowDown'].includes($event.key) ? direction = 'down' : 
                        ['a', 'ArrowLeft'].includes($event.key) ? direction = 'left' : 
                        ['d', 'ArrowRight'].includes($event.key) ? direction = 'right' : ''"
     x-on:keydown.window.debounce.100ms="$dispatch('movePlayer', direction)"
     class="flex flex-col items-center">
    
    <h1 class="text-3xl font-bold mb-4">Maze Dungeon</h1>

    @if($gameState === 'select')
        <div class="mb-4">
            <label for="difficulty" class="block text-lg mb-2">Select Difficulty:</label>
            <select wire:model.live="difficulty" id="difficulty" class="p-2 border rounded">
                <option value="easy">Easy (5x5)</option>
                <option value="medium">Medium (10x10)</option>
                <option value="hard">Hard (15x15)</option>
            </select>
           
            <button wire:click="startGame" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Start Game
            </button>
        </div>
    @elseif($gameState === 'playing')
    <div class="mb-4">
        <p class="text-lg">Debug: Game State is {{ $gameState }}</p>
        <p class="text-lg">Difficulty: {{ ucfirst($difficulty) }}</p>
        <p class="text-lg">Moves: {{ $moves }}</p>
    </div>
    <div class="grid gap-0" style="grid-template-columns: repeat({{ $width }}, 40px);">
        @foreach($maze as $row)
            @foreach($row as $cell)
                <div class="{{ [
                    1 => 'bg-gray-800',
                    2 => 'bg-blue-500',
                    3 => 'bg-green-500',
                    0 => 'bg-white'
                ][$cell] }} w-10 h-10 border border-gray-300"></div>
            @endforeach
        @endforeach
    </div>
    <p class="mt-4 text-lg">Use WASD or Arrow Keys to move</p>
    @elseif($gameState === 'won')
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Congratulations! You Won!</h2>
            <p class="text-lg">Difficulty: {{ ucfirst($difficulty) }}</p>
            <p class="text-lg">Moves: {{ $moves }}</p>
            <button wire:click="resetGame" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Play Again
            </button>
        </div>
    @endif
</div>