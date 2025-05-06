@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-8">TeoGame Calculators</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tools as $tool)
         
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <h2 class="text-xl font-semibold mb-2">{{ $tool['name'] }}</h2>
                <p class="text-gray-600 mb-4">{{ $tool['description'] }}</p>
                <a href="{{ url('/tools/' . $tool['slug']) }}" class="text-blue-500 font-medium hover:underline">
                    Try Now →
                </a>
            </div>
            @endforeach

            {{-- @foreach ($tools as $tool)
                <div>
                    <h2>{{ $tool['name'] }}</h2>
                    <p>{{ $tool['description'] }}</p>
                    <a href="{{ url('/tools/' . $tool['slug']) }}">Try Now</a>
                </div>
            @endforeach --}}
        </div>
    </div>
@endsection
