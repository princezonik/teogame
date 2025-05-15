<!DOCTYPE html>
<html>
    <head>
        <title>Robux ↔ USD Converter</title>
        <style>
            body { font-family: sans-serif; padding: 40px; }
            input { padding: 8px; margin-bottom: 10px; width: 200px; }
            button { padding: 10px 15px; }
            .result { margin-top: 20px; }
        </style>
    </head>
    <body>
        <h1>Robux ↔ USD Converter</h1>

        <form method="POST" action="{{ route('convert') }}">
            @csrf

            <div>
                <label>Robux:</label><br>
                <input type="number" step="any" name="robux" value="{{ old('robux', $robux ?? '') }}">
            </div>

            <div>
                <label>USD:</label><br>
                <input type="number" step="any" name="usd" value="{{ old('usd', $usd ?? '') }}">
            </div>

            <button type="submit">Convert</button>
        </form>

        @if(isset($robux) && isset($usd))
            <div class="result">
                <strong>Result:</strong><br>
                {{ number_format($robux, 2) }} Robux ↔ ${{ number_format($usd, 2) }} USD
            </div>
        @endif
    </body>
</html>
