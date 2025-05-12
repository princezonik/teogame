<!-- Main layout -->
<div class="flex h-screen w-screen bg-[#f9f9f9]  ">


    <!-- navbar (top) -->
    {{-- @livewire('nav-bar') --}}
    <!-- Sidebar (left) -->
    {{-- <div class="w-1/4  flex justify-center items-center font-sans">
      @livewire('sidebar')
    </div> --}}

    <!-- Middle (puzzle + sticky navbar) -->
    <div class=" w-3/5 h-full   mx-auto ">
      @livewire('feature-grid')
      
      
      {{-- @livewire('puzzle-view')  <!-- This renders the Livewire component --> --}}
        {{-- <livewire:puzzle-view  /> --}}
        {{-- @livewire('game-2048') --}}
        {{-- @livewire('sliding-puzzle') --}}
        {{-- @livewire('play-puzzle') --}}

      <div class="mt-10 mb-10">
        
        @livewire('section-card')
      </div>
    </div>

    
    <!-- Right (tools) -->
    {{-- <div class="w-1/4  flex justify-center items-center bg-[#192440] p-4 overflow-y-scroll ">
      @livewire('tools-panel')
    </div>  --}}
    
   
</div>
