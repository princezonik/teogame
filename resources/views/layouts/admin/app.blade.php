<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    

        <title>@yield('title', 'Home') - {{ config('app.name', 'TeoGame') }}</title>
        
     
        
        
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        {{-- Global Styles --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" />

        {{-- Page Specific Styles --}}
        
        {{-- Favicon (optional) --}}
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        
        
        @stack('styles')
        @livewireStyles
    </head>

    <body id="kt_body " class="w-screen h-screen  font-sans antialiased flex flex-col overflow-x-hidden header-fixed sidebar-enabled">
        
        <!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		
        <div 
            x-data="{ show: false, message: '', type: 'success' }"
            x-on:notify.window="
                show = true;
                message = $event.detail.message;
                type = $event.detail.type;
                setTimeout(() => show = false, 3000);
            "
            x-show="show"
            x-transition
            class="fixed top-4 right-4 px-4 py-2 rounded shadow-lg text-white"
            :class="{
                'bg-green-500': type === 'success',
                'bg-red-500': type === 'error',
                'bg-yellow-500': type === 'warning',
                'bg-blue-500': type === 'info'
            }"
            style="display: none;">
            
            <span x-text="message"></span>
        </div>


        <aside>
            <livewire:admin.partials.sidebar />
        </aside>

        <div  class="fixed top-4 right-4 z-50">
            <livewire:admin.partials.profile-modal />
        </div>

        
        {{$slot}}




         <!--begin::Javascript-->
        <!--begin::Global Javascript Bundle (mandatory for all pages)-->
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <!--end::Global Javascript Bundle-->

        <!--begin::Vendors Javascript (used for this page only)-->
        <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>


        <!--begin::Custom Javascript (used for this page only)-->
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
        <!--end::Custom Javascript-->

        

        @stack('scripts')
        @livewireScripts
       <script>
            // Initialize game data with Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.on('gameReady', (gameId) => {
                    window.gameId = gameId; // Make sure this is set
                    console.log('Game ID set:', window.gameId);
                    
                    // Reinitialize Echo with the proper gameId
                    if (typeof initializeEcho === 'function') {
                        initializeEcho();
                    }
                });
            });

            document.addEventListener('alpine:init', () => {
                Alpine.store('adminSidebar', {
                    open: false,
                    toggle() { this.open = !this.open },
                    close() { this.open = false }
                });
            });

        </script> 


    </body>

    
</html>
