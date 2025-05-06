<!DOCTYPE html>
<html>
    <body>
        <div class="max-w-md mx-auto bg-white p-6 shadow rounded space-y-6">
            <h2 class="text-xl font-bold">🔋 Gaming Electricity Cost Calculator</h2>

            <form method="POST" action="{{ route('electricity.calculate') }}">
                @csrf

                <div>
                    <label>System Power (Watts)</label>
                    <input type="number" name="wattage" class="w-full border p-2 rounded"
                        value="{{ old('wattage', 450) }}" required>
                </div>

                <div>
                    <label>Electricity Rate ($ per kWh)</label>
                    <input type="number" step="0.01" name="rate_per_kwh" class="w-full border p-2 rounded"
                        value="{{ old('rate_per_kwh', 0.15) }}" required>
                </div>

                <div>
                    <label>Daily Gaming Time (Hours)</label>
                    <input type="number" step="0.1" name="hours_per_day" class="w-full border p-2 rounded"
                        value="{{ old('hours_per_day', 4) }}" required>
                </div>

                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">Calculate</button>
            </form>

            @isset($result)
                <div class="mt-4 p-4 rounded bg-green-100 space-y-2">
                    <strong>Cost per hour:</strong> ${{ number_format($result->cost_per_hour, 4) }} <br>
                    <strong>Cost per day:</strong> ${{ number_format($result->cost_per_day, 4) }} <br>
                    <strong>Cost per month:</strong> ${{ number_format($result->cost_per_month, 4) }}
                </div>
            @endisset
        </div>
    </body>
</html>
