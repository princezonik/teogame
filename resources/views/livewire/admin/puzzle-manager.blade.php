@php
use App\Models\Puzzle;
@endphp

<div class="p-6 ml-[266px]">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daily Puzzle Management</h2>

   

    <!-- Current Status Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Current Status</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Today's Game</p>
                <p class="text-lg font-semibold">
                    {{ $currentDailyGame->title ?? 'Not set' }}
                </p>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Today's Puzzle</p>
                <p class="text-lg font-semibold">
                    {{ $todayPuzzle ? 'Generated' : 'Not generated' }}
                </p>
                @if($todayPuzzle)
                    <p class="text-sm text-gray-600 mt-1">
                        Grid: {{ $todayPuzzle->grid_size }}x{{ $todayPuzzle->grid_size }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Game Selection Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Set Daily Game</h3>
        
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Game</label>
                <select wire:model="selectedGameId" class="w-full border rounded-md px-3 py-2">
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}">{{ $game->title }}</option>
                    @endforeach
                </select>
                @error('selectedGameId')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <button wire:click="setDailyGame" 
                    wire:loading.attr="disabled"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                Set as Today's Game
            </button>
        </div>
    </div>

    <!-- Puzzle Generation Card -->
    <div class="bg-white rounded-lg shadow p-6 mb-6 border border-gray-200">
        <h3 class="text-lg font-semibold mb-4">Generate Puzzle</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Game</label>
                <select wire:model="selectedGameId" class="w-full border rounded-md px-3 py-2">
                    <option value="">Select a game</option>
                    @foreach($games as $game)
                        <option value="{{ $game->id }}"  @if(!$game->can_generate) disabled class="text-gray-400 bg-gray-100" @endif>{{ $game->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" wire:model="generationDate" 
                       class="w-full border rounded-md px-3 py-2">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Grid Size</label>
                <select wire:model="gridSize" class="w-full border rounded-md px-3 py-2">
                    <option value="3">3x3</option>
                    <option value="4">4x4</option>
                    <option value="5" selected>5x5</option>
                    <option value="6">6x6</option>
                    <option value="7">7x7</option>
                    <option value="8">8x8</option>
                    <option value="9">9x9</option>
                    <option value="10">10x10</option>
                </select>
            </div>
        </div>
        
        <div class="flex gap-4">
            <button wire:click="generatePuzzle" 
                    wire:loading.attr="disabled"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors">
                Generate Puzzle
            </button>
            
            <button wire:click="regenerateTodayPuzzle" 
                    wire:loading.attr="disabled"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md transition-colors">
                Regenerate Puzzle
            </button>
        </div>
    </div>

    <!-- Recent Puzzles Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold">Recent Puzzles</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Game</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grid Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse(Puzzle::orderBy('date', 'desc')->limit(5)->get() as $puzzle)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $puzzle->date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $puzzle->game->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $puzzle->grid_size }}x{{ $puzzle->grid_size }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($game->can_generate)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Generated
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Not Generated
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No puzzles found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>