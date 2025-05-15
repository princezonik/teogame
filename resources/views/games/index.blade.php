@extends('layouts.app')
@section('content')
<div class="p-6  min-h-screen text-white">
    @livewire('games',[ 'games' => $games])
</div>

@endsection