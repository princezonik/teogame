<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    

        <title>@yield('title', 'Home') - {{ config('app.name', 'TeoGame') }}</title>
        
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
        {{-- Global Styles --}}
        <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}" />

        {{-- Page Specific Styles --}}
        
        {{-- Favicon (optional) --}}
        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />

       
    </head>


    <body class="font-sans antialiased flex flex-col overflow-x-hidden">

        <main >
            @yield('content')
        </main>
 
        @livewire('footer')
        

        
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

</html>
