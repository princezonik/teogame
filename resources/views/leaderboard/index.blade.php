@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Leaderboard - Top 20</h1>
    <div id="toast">
        
    </div>
    @if($formatted->isEmpty())
        <p>No scores available yet.</p>
    @else
        <table id="leaderboard-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Score</th>
                    <th>Best Moves</th>
                </tr>
            </thead>
            
            <tbody id="leaderboard-body">
                @foreach($scores as $index => $score)
                    <tr data-user-id="{{ $score->user_id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $score->user->name }}</td>
                        <td>{{ $score->score }}</td>
                        <td>{{ $score->best_moves }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
    
@endsection

@push('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endpush

