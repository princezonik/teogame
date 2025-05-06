<!DOCTYPE html>
<html>
    <body>

        <div class="max-w-md mx-auto bg-white shadow p-6 rounded space-y-6">
            <h2 class="text-xl font-bold">🎮 Twitch Revenue Estimator</h2>

            <form method="POST" action="{{ route('twitch.estimate') }}">
                @csrf

                <div>
                    <label>Tier 1 Subscribers</label>
                    <input type="number" name="tier1_subs" class="w-full border p-2 rounded"
                        value="{{ old('tier1_subs', $tier1_subs ?? 0) }}">
                </div>

                <div>
                    <label>Bits Received</label>
                    <input type="number" name="bits" class="w-full border p-2 rounded"
                        value="{{ old('bits', $bits ?? 0) }}">
                </div>

                <div>
                    <label>Ad Views (Monthly)</label>
                    <input type="number" name="ad_views" class="w-full border p-2 rounded"
                        value="{{ old('ad_views', $ad_views ?? 0) }}">
                </div>

                <button class="mt-4 bg-purple-600 text-white px-4 py-2 rounded">Estimate Revenue</button>
            </form>

            @isset($estimated_revenue)
                <div class="bg-green-100 p-4 rounded mt-4">
                    <strong>Estimated Monthly Revenue:</strong> ${{ number_format($estimated_revenue, 2) }}
                </div>
            @endisset
        </div>

    </body>
</html>
