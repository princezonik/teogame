<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LootDrop Chance Simulator</title>
    </head>
    <body>
        <div class="max-w-md mx-auto bg-white shadow p-6 rounded space-y-4">
        <h2 class="text-xl font-bold">EXP Needed to Reach Level N</h2>

        <form method="POST" action="{{ route('exp.calculate') }}">
            @csrf

            <div>
                <label for="current_exp">Current EXP:</label>
                <input type="number" id="current_exp" name="current_exp" class="w-full border p-2 rounded" value="{{ old('current_exp', $current_exp ?? 0) }}">
                @error('current_exp') <p class="text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="target_level">Target Level:</label>
                <input type="number" id="target_level" name="target_level" class="w-full border p-2 rounded" value="{{ old('target_level', $target_level ?? 1) }}">
                @error('target_level') <p class="text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="curve">Leveling Curve:</label>
                <select id="curve" name="curve" class="w-full border p-2 rounded">
                    <option value="linear" {{ (old('curve', $curve ?? '') === 'linear') ? 'selected' : '' }}>Linear (100 × L)</option>
                    <option value="exponential" {{ (old('curve', $curve ?? '') === 'exponential') ? 'selected' : '' }}>Exponential (50 × L²)</option>
                </select>
                @error('curve') <p class="text-red-500">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Calculate</button>
        </form>

        @isset($remaining_exp)
            <div class="p-4 bg-green-100 rounded">
                <p><strong>Total EXP needed:</strong> {{ $total_required_exp }}</p>
                <p><strong>Remaining EXP:</strong> {{ $remaining_exp }}</p>
            </div>
        @endisset
        </div>
    </body>
</html>
