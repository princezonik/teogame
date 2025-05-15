@extends('layouts.app')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-[#faf8ef]">
        <h1 class="text-4xl font-bold mb-4">{{ $game->title }}</h1>
        
        <!-- Game-Specific Content (such as 2048) -->
        @if($game->title === '2048')
           @livewire('game2048', ['game' => $game])
        @elseif($game->title === 'Sliding Puzzle')
            @livewire('sliding-puzzle', ['game' => $game])
        @elseif($game->title === 'Color Pipe')
            @livewire('puzzle-view', ['game' => $game])
        @endif
    </div>
@endsection
