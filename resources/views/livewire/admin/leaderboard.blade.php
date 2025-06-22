<div class="p-4 ml-[266px]">
    <h2 class="text-xl font-bold mb-4">Leaderboard (Admin)</h2>

    <!-- Filters Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
        <!-- Game Selection -->
        <div>
            <label for="game" class="block text-sm font-medium text-gray-700">Select Game:</label>
            <select wire:model.live="gameId" id="game" class="mt-1 block w-full border rounded-md p-2">
                @foreach($games as $game)
                    <option value="{{ $game->id }}">{{ $game->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Score and Moves Filters -->
        <div>
            <label for="scoreFilter" class="block text-sm font-medium text-gray-700">Min Score:</label>
            <input type="number" wire:model.live.debounce.500ms="scoreFilter" id="scoreFilter" 
                   class="mt-1 block w-full border rounded-md p-2" placeholder="Filter by score">
        </div>

        <div>
            <label for="movesFilter" class="block text-sm font-medium text-gray-700">Min Moves:</label>
            <input type="number" wire:model.live.debounce.500ms="movesFilter" id="movesFilter" 
                   class="mt-1 block w-full border rounded-md p-2" placeholder="Filter by moves">
        </div>
    </div>

    <!-- Toggle Filters -->
    <div class="flex flex-wrap gap-4 mb-6">
        <label class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow">
            <input type="checkbox" wire:model.live="showOnlySuspicious">
            <span class="text-sm font-medium">Show suspicious scores</span>
        </label>

        <label class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow">
            <input type="checkbox" wire:model.live="showOnlyFlagged">
            <span class="text-sm font-medium">Show only flagged</span>
        </label>
    </div>

    <!-- Info Bar -->
    <div class="mb-4 p-3 bg-blue-50 rounded-lg text-sm text-gray-700">
        Showing {{ $scores->count() }} of {{ $scores->total() }} scores
        @if($gameId) | Game: {{ $games->find($gameId)->title }} @endif
        @if($showOnlySuspicious) | Suspicious only @endif
        @if($showOnlyFlagged) | Flagged only @endif
        @if($scoreFilter) | Min score: {{ $scoreFilter }} @endif
        @if($movesFilter) | Min moves: {{ $movesFilter }} @endif
    </div>

    <!-- Scores Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Best Move</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($scores as $score)
                    <tr class="{{ $score->is_flagged ? 'bg-red-50' : '' }} 
                              {{ ($score->score > 100 || $score->moves < 25) && !$score->is_flagged ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $score->user->name ?? 'Guest' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $score->score }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $score->best_moves }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $score->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="flagScore({{ $score->id }})" 
                                
                                    class="px-3 py-1 text-sm rounded-md 
                                           {{ $score->is_flagged ? 'bg-green-100 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $score->is_flagged ? 'Unflag' : 'Flag' }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No scores found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $scores->links() }}
    </div>
</div>