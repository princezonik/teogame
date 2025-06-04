<div>
 

    <div class="text-white">
    <div id="toast" style="display: none; position: fixed; top:20px; background: #28a745; color: white; padding:10px 20px; border-radius:5px;">
        
    </div>

    @if(collect($scores)->isEmpty())
        <p>No scores available yet.</p>
    @else 
        <table id="leaderboard-table" class=" " style="width: 300px">
            <thead>
                <tr class="">
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Score</th>
                </tr>
            </thead>
            
            <tbody id="leaderboard-body" class="text-white">
                @foreach($scores as $index => $score)
                    <tr data-user-id="{{ $score['user_id'] }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $score['user_name'] }}</td>
                        <td>{{ $score['score'] }}</td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
    @endif
</div>
</div>
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
        
    </style>
@endpush