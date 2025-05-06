<div class="   h-4/5  rounded-3xl flex flex-col justify-between shadow">
    @if ($currentCalculator)
        @livewire( \Str::kebab($currentCalculator), key($currentCalculator))
    @else
        <p class="text-gray-500">Select a calculator from the sidebar.</p>
    @endif
</div>
