<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Steam Backlog BreakEven Timer</title>
    </head>

    
    <body>
        <h1>Steam Backlog BreakEven Timer</h1>
        
        <form action="{{ route('steam_backlog.calculate') }}" method="POST">
            @csrf
            <div>
                <label for="total_backlog_hours">Total Backlog Hours:</label>
                <input type="number" name="total_backlog_hours" value="{{ old('total_backlog_hours') }}" required min="1">
            </div>
            
            <div>
                <label for="average_weekly_playtime">Average Weekly Playtime (hours):</label>
                <input type="number" name="average_weekly_playtime" value="{{ old('average_weekly_playtime') }}" required min="1">
            </div>

            <button type="submit">Calculate</button>
        </form>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </body>
</html>
