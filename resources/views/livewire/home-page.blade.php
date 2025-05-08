<!-- Main layout -->
<div class="flex h-screen w-screen bg-[#f9f9f9]  ">
    <!-- Sidebar (left) -->
    <div class="w-1/4  flex justify-center items-center font-sans">
       @livewire('sidebar')
    </div>

    <!-- Middle (puzzle + sticky navbar) -->
    <div class="flex w-3/5 h-1/3 justify-center ">

        {{-- @livewire('puzzle-view')  <!-- This renders the Livewire component --> --}}
        {{-- <livewire:puzzle-view  /> --}}
        @livewire('game-2048')
    </div>

    <!-- Right (tools) -->
    <div class="w-1/4  flex justify-center items-center bg-[#192440] p-4 overflow-y-scroll ">
      @livewire('tools-panel')
    </div> 
</div>
