<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'TeoGame' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles


</head>
<body class="bg-gray-100 text-gray-800">
    {{ $slot }}
    
    @livewireScripts
    {{-- <script defer src="//unpkg.com/alpinejs" defer></script> --}}
</body>
</html>
