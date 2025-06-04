<x-app-layout>

    @section('content')

        <div class="flex">
            @livewire('nav-bar')
        </div>

        @livewire('games')

        @livewire('aside')
        
        @livewire('footer')

        
    @endsection
</x-app-layout>
