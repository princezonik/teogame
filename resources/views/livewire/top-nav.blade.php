<nav
    id="smart-navbar"
    x-data="navbarScroll"
    x-init="init()"
    :class="{ '-top-24': hideNavbar, 'top-0': !hideNavbar }"
    class="fixed w-full max-w-4xl left-0 right-0 mx-auto z-50 transition-all duration-300"
>
    <div class="bg-white shadow px-4 py-3 flex justify-between items-center text-black">
        <div class="text-xl font-bold">TeoGame</div>
        <ul class="flex space-x-6">
           <li><a href="{{ route('games.index') }}" class="hover:text-yellow-400">Games</a></li>
            {{-- <li><a href="" class="hover:text-yellow-400">Puzzle</a></li>
            <li><a href="" class="hover:text-yellow-400">Calculators</a></li>
            <li><a href="" class="hover:text-yellow-400">Leaderboard</a></li> --}}
        </ul>
    </div>
</nav>




@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navbarScroll', () => ({
                lastScroll: window.scrollY,
                hideNavbar: false,
                init() {
                    window.addEventListener('scroll', () => {
                        const currentScroll = window.scrollY;

                        // Show when near top
                        if (currentScroll < 100) {
                            this.hideNavbar = false;
                            this.lastScroll = currentScroll;
                            return;
                        }

                        // Scroll down -> hide
                        if (currentScroll > this.lastScroll) {
                            this.hideNavbar = true;
                        }
                        // Scroll up -> show
                        else if (currentScroll < this.lastScroll) {
                            this.hideNavbar = false;
                        }

                        this.lastScroll = currentScroll;
                    });
                }
            }))
        });
    </script>
@endpush