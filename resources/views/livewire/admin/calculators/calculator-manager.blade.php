<div>
    <h2 class="text-xl font-semibold mb-4">Calculator Manager</h2>
    <ul>
        @foreach($calculators as $calc)
            <li class="mb-2">
                <strong>{{ $calc->name }}</strong> ({{ $calc->slug }}) - {{ $calc->description }}
            </li>
        @endforeach
    </ul>
</div>
