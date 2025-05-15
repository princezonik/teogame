<div class="p-6 max-w-md mx-auto bg-gray-900 text-white shadow-xl rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-white">Steam Backlog Break Even Timer</h2>

    <p class="text-sm text-gray-400 mb-6 text-center">
        Estimate how many days it will take to finish your backlog based on your average weekly play time.
    </p>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Total Backlog Hours</label>
        <input type="number" wire:model.live="backlogHours"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Average Weekly Play Time (hrs)</label>
        <input type="number" wire:model.live="weeklyPlayHours"
            class="w-full bg-gray-800 text-white border border-gray-600 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Estimated Time to Finish</label>
        <div class="p-2 bg-gray-700 rounded-lg">
            {{ $daysToFinish !== null ? $daysToFinish . ' days' : '—' }}
        </div>
    </div>

    <div class="mt-6 p-4 bg-gray-800 border border-gray-700 rounded-lg text-sm space-y-1">
        <p class="font-semibold">Tip:</p>
        <p class="text-gray-400">This tool helps you estimate how many days it will take to finish your Steam backlog based on your weekly playtime. Simply input your total backlog hours and average playtime to see the estimate.</p>
    </div>
</div>
