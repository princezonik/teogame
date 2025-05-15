<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6">{{ $game->title }}</h1>
    <div class="bg-[#363d44] p-4 rounded">
        <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-64 object-cover mb-4 rounded">
        <p class="text-gray-300">{{ $game->description }}</p>
        <!-- You can add more details, like gameplay or instructions, here -->
    </div>
</div>