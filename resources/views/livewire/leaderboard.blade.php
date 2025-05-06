<div>
    <h2 class="text-xl font-semibold mb-3">Today's Top 10</h2>
    <ol class="list-decimal ml-6">
        @foreach($leaders as $leader)
            <li>{{ $leader->user->name }} - {{ $leader->time_ms }} ms</li>
        @endforeach
    </ol>
</div>
