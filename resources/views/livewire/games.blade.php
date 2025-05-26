
<div class="p-6 min-h-screen text-white"
    x-data="{
        loading: true,
        init() {
            // Call Livewire method from Alpine
            this.$wire.loadGame('{{ $games->slug ?? '' }}');
            
            this.$wire.on('game-loaded', (payload) => {
                window.gameId = payload.gameId;
                window.currentGameSlug = payload.slug;

                if (typeof initializeEcho === 'function') {
                    initializeEcho();
                }

                this.loading = false;
            });

            this.$wire.on('setGameId', (payload) => {
                window.gameId = payload.gameId;
                window.currentGameSlug = payload.slug;
                console.log('setGameId received:', payload);
                if (typeof initializeEcho === 'function') {
                    initializeEcho();
                }
            });
        }
    }"
>

    @if($games)
        
        <!-- Loading state -->
        <div x-show="loading" class="text-center py-8">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto"></div>
            <p class="mt-2">Loading game...</p>
        </div>

        <!-- Game content -->
        <div x-show="!loading" class="bg-[#192440] transition-opacity duration-300">
            @livewire($games->slug, ['game' => $games], key($games->id))
        </div>
    
    @else
        <p class="text-center py-8">No game available today.</p>
    @endif
</div>
