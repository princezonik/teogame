@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">🏆 Leaderboard</h2>

        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4">#</th>
                    <th class="py-2 px-4">User</th>
                    <th class="py-2 px-4">Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $index + 1 }}</td>
                        <td class="py-2 px-4">{{ $user->name }}</td>
                        <td class="py-2 px-4">{{ $user->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection





