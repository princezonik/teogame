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
	<body id="kt_body" class="header-fixed sidebar-enabled">

		@livewire('home-page')

	
		
    @livewire('footer')
        
    
    
    
    
    <!--begin::Javascript-->
        {{-- <script>var hostUrl = "{{ asset('assets') }}/";</script> --}}

        <!--begin::Global Javascript Bundle (mandatory for all pages)-->
        <!--end::Global Javascript Bundle-->
		
      <!--begin::Vendors Javascript (used for this page only)-->
        <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
        <script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script> 
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