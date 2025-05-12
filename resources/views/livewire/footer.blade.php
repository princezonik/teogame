<footer class="bg-gray-900 text-white py-8 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Section 1: Logo / Description -->
            <div>
                <h2 class="text-xl font-semibold text-[#1aa3e3]">TeoGame</h2>
                <p class="mt-2 text-sm text-gray-400">
                    {{ $description }}
                </p>
            </div>

            <!-- Section 2: Quick Links -->
            <div>
                <h3 class="text-md font-semibold mb-2">Quick Links</h3>
                <ul class="space-y-1 text-sm text-gray-400">
                    @foreach ($links as $label => $url)
                        <li><a href="{{ $url }}" class="hover:text-white">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Section 3: Contact -->
            <div>
                <h3 class="text-md font-semibold mb-2">Connect</h3>
                <ul class="space-y-1 text-sm text-gray-400">
                    <li>
                        <a href="mailto:{{ $supportEmail }}" class="hover:text-white">{{ $supportEmail }}</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
        <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ now()->year }} TeoGame. All rights reserved.
        </div>
    </div>
</footer>
