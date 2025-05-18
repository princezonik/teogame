<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'Home') - {{ config('app.name', 'TeoGame') }}</title>
        
		@vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Global Styles --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" />
		<link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css')}}" />
		<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css')}}" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />


        {{-- Page Specific Styles --}}
        
        {{-- Favicon (optional) --}}
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
        @livewireStyles
        @stack('styles')
    </head>

	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed sidebar-enabled">

		@livewire('home-page')

	
		
    {{-- @livewire('footer') --}}
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
		@livewireScripts
        @stack('scripts')
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
       
    </body>
	<!--end::Body-->
</html>