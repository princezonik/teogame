<x-app-layout>


    @section('content')

        <div class="flex">
            @livewire('nav-bar')
        
        </div>

        @livewire('games')

        @livewire('aside')
    @endsection
</x-app-layout>
