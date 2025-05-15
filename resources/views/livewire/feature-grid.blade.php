
<div class=" max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 bg-slategray text-[#aaa] shadow-lg">
    @foreach ($features as $feature)
        <div class="bg-darkslate p-4 hover:shadow-xl transition flex flex-col rounded">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-300">{{ $feature['description'] }}</p>
                </div>

                <div class="mt-auto">
                    <a href=""
                    class="bg-blue-500 hover:bg-actionblue text-white px-4 py-2 transition inline-block w-full text-center mt-4 rounded">
                        {{ $feature['title'] }}
                    </a>
                </div>
        </div>
    @endforeach
</div>