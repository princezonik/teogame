<!DOCTYPE html>
<html>
    <body>
        <div class="max-w-md mx-auto bg-white shadow p-6 rounded space-y-6">
            <h2 class="text-xl font-bold">🧪 VRAM Fit Checker</h2>

            <form method="POST" action="{{ route('vram.check') }}">
                @csrf

                <div>
                    <label>GPU VRAM (MB)</label>
                    <input type="number" name="vram_mb" class="w-full border p-2 rounded" required
                        value="{{ old('vram_mb', 4096) }}">
                </div>

                <div>
                    <label>Texture Pack Size (MB)</label>
                    <input type="number" name="texture_pack_mb" class="w-full border p-2 rounded" required
                        value="{{ old('texture_pack_mb', 2048) }}">
                </div>

                <button class="bg-blue-600 text-white px-4 py-2 mt-4 rounded">Check Fit</button>
            </form>

            @isset($result)
                <div class="mt-4 p-4 rounded {{ $result->status === 'Fits' ? 'bg-green-100' : 'bg-red-100' }}">
                    <strong>Status:</strong> {{ $result->status }} <br>
                    <span class="text-sm text-gray-600">GPU VRAM: {{ $result->vram_mb }} MB<br>Texture Pack: {{ $result->texture_pack_mb }} MB</span>
                </div>
            @endisset
        </div>
    </body>
</html>
