<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>{{ $title ?? 'TeoGame' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">


        
        
        @livewireStyles
        @stack('styles')
    </head>
    <body class="bg-gray-100 text-gray-800">
        {{ $slot }}
        
        
        @livewireScripts
        {{-- <script defer src="//unpkg.com/alpinejs" defer></script> --}}
        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </body>

</html>
