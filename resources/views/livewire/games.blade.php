<div class="p-6  min-h-screen text-white">
    <h1 class="text-2xl font-bold mb-6">Game Catalog</h1>

    <div class="max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach ($games as $game)
            <a href="{{ route('games.show', $game->id) }}" class="block bg-[#363D44]  hover:shadow-lg transition">
                <img src="{{ asset($game->image) }}" alt="{{ $game->title }}" class="w-full h-[12.5rem] object-cover ">
                <div class="font-semibold truncate bg-[#42484E] p-1">{{ $game->title }}</div>
                <p class="text-sm text-gray-400 px-1 pt-1 bg-[#363d44] line-clamp-3">{{ $game->description }}</p></a>
        @endforeach
    </div>
</div>
