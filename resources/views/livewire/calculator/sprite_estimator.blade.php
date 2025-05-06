<!DOCTYPE html>
<html>
    <body>
        <div class="max-w-lg mx-auto p-6 bg-white rounded shadow space-y-6">
            <h2 class="text-xl font-bold">🎨 PixelArt Cost Estimator</h2>

            <form method="POST" action="{{ route('sprite.estimate') }}">
                @csrf

                <div>
                    <label class="block">Number of Frames</label>
                    <input type="number" name="frames" value="{{ old('frames', $frames ?? 1) }}"
                        class="w-full border p-2 rounded" required>
                    @error('frames') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block">Freelancer Rate (per frame in USD)</label>
                    <input type="number" step="0.01" name="rate" value="{{ old('rate', $rate ?? 5.00) }}"
                        class="w-full border p-2 rounded" required>
                    @error('rate') <p class="text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="mt-2 text-sm text-gray-600">
                    Benchmarks:
                    <ul class="list-disc pl-5">
                        <li><strong>Fiverr indie:</strong> $2–$5/frame</li>
                        <li><strong>Experienced artist:</strong> $10–$25/frame</li>
                        <li><strong>Studio-quality:</strong> $40–$100+/frame</li>
                    </ul>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-4 rounded">Estimate</button>
            </form>

            @isset($total)
                <div class="bg-green-100 p-4 rounded shadow mt-4">
                    <p><strong>Total Budget:</strong> ${{ number_format($total, 2) }}</p>
                </div>
            @endisset
        </div>
    </body>
</html>