<div>
    <nav class="text-sm text-gray-600 mb-4">
        <ol class="list-reset flex">
            @foreach ($items as $index => $item)
                <li>
                    @if (!empty($item['url']))
                        <a href="{{ $item['url'] }}" class="text-blue-600 hover:underline">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif

                    @if (!$loop->last)
                        <span class="mx-2">/</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
</div>
