<x-app-layout>

    @section('content')

        <div class="flex flex-col">

            <div class="flex">
                @livewire('nav-bar')
            </div>
    
            <div>
                @livewire('games')
    
            </div>
    
    
            @livewire('aside')
    
            
            <livewire:footer />
        </div>
    @endsection
</x-app-layout>
