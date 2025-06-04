

<div class="container">

    <h1>Leaderboard - Top 20</h1>


    <div id="leaderboard-container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Player</th>
                    <th>Score</th>
                    <th>Best Moves</th>
                </tr>
            </thead>
            <tbody id="leaderboard-body">
                <!-- Data will be loaded here via JavaScript -->
            </tbody>
        </table>
        <div id="loading" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
@push('scripts')
 <script>
    function fetchLeaderboard() {

const gameId = {{ $game_id ?? '1' }}; // You need to pass $game_id from the controller or set it in JS

const difficulty = null; // or get from a filter

const url = '/leaderboard/data?' + new URLSearchParams({ game_id: gameId, difficulty: difficulty });

fetch(url, {

method: 'GET',

headers: {

'Accept': 'application/json',

}

})

.then(response => response.json())

.then(data => updateLeaderboardDOM(data.scores))

.catch(error => console.error('Error:', error));

}
 </script>

@endpush