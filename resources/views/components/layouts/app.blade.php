<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'Home') - {{ config('app.name', 'TeoGame') }}</title>
        
        
        {{-- Global Styles --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" />
		<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css')}}" />
		<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css')}}" />
        

        {{-- Page Specific Styles --}}
        
        {{-- Favicon (optional) --}}
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        @livewireStyles
		@vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>

	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="w-screen h-screen  font-sans antialiased flex flex-col overflow-x-hidden header-fixed sidebar-enabled">
        <!--begin::Theme mode setup on page load-->
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		
		@livewire('home-page')

	
        
    
    
        <!--end::Vendors Javascript-->
        {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
        <!--begin::Custom Javascript (used for this page only)-->
		<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
        <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
        <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
        
        <!--end::Custom Javascript-->

        <!--end::Javascript-->

        
        @stack('scripts')
        @livewireScripts
        {{-- <script>
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
        </script> --}}
    </body>
	<!--end::Body-->
</html>