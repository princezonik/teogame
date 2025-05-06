<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LootDrop Chance Simulator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            max-width: 500px;
            margin: auto;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
    </head>
    <body>
        <h1>LootDrop Chance Simulator</h1>

        <form method="POST" action="{{ route('lootdrop.calculate') }}">
        @csrf
        <div>
            <label for="probability">Single-draw Probability (p) [%]:</label>
            <input type="number" step="any" name="probability" id="probability" placeholder="Enter probability of rare item in one pull" required>
        </div>

        <div>
            <label for="pulls">Number of Pulls (n):</label>
            <input type="number" name="pulls" id="pulls" placeholder="Enter number of pulls" required>
        </div>

        <button type="submit">Calculate Chance</button>
        </form>

        @isset($lootDropChance)
        <div class="result">
            Cumulative Chance of getting at least one rare item: <strong>{{ number_format($lootDropChance * 100, 2) }}%</strong>
        </div>
        @endisset
    </body>
</html>
