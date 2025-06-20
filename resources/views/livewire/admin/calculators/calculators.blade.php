<div class="flex flex-col ml-[265px] p-[50px]">
    <!-- session flash -->
    <div class="h-[20px]">
        
        <div 
            x-data="{ show: false, message: '' }"
            x-init="
                window.addEventListener('show-message', e => {
                    message = e.detail.text;
                    show = true;
                    setTimeout(() => show = false, 3000);
                });
            "
            x-show="show"
            x-transition
            class="bg-green-100 text-green-800 p-2 rounded mb-3"
            x-text="message"
            x-cloak>
            
        </div>

    </div>

    
    <div class="mb-[30px] mt-[30px]" >
        
        <div class="calculator-tabs">
            <h1 class="text-xl font-semibold mb-4">Calculators</h1>
            
            <livewire:admin.partials.breadcrumb :items="[
                [
                    'label' => 'Dashboard', 
                    'url' => route('admin.dashboard')
                ],

                ['label' => 'Calculators']
            ]" />
        </div>

    </div>


    <div class="space-y-6  ">

        <table class="min-w-full bg-white border shadow-sm rounded ">
            <thead class="w-full">
                <tr class="bg-gray-100 text-left text-[#63727b]">
                    <th class="p-3"><input type="checkbox" /></th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Description</th>
                    <th class="p-3 ">Visibility</th>
                    <th class="p-3 ">Date</th>
                    <th class="p-3 "></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paginatedCalculators as $calculator)
                    <tr class="border-t hover:bg-gray-50 text-lg font-bold">
                        <td class="p-3">
                            <input type="checkbox" />
                        </td>
                        <td class="p-3 text-[#63727b] text-bold">{{ $calculator->title }}</td>
                        <td class="p-3  text-[#63727b] text-bold">{{ $calculator->description }}</td>
                        <td class="p-3 ">
                            
                            <button
                                wire:click="toggleVisibility({{ $calculator->id }})"
                                class="text-sm px-2 py-1 rounded
                                    {{ $calculator->is_visible ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $calculator->is_visible ? 'Visible' : 'Hidden' }}
                            </button>
                            
                        </td>
                        <td class="p-3  text-[#63727b] text-bold">{{ \Carbon\Carbon::parse($calculator->updated_at)->format('d M Y') }}</td>
                        <td class="p-3" x-data="{ open: false }">
                            <!-- begin::modal -->
                            <div class="relative">
                                <button @click="open = !open" class="text-gray-600 hover:text-black">
                                    ⋮
                                </button>
                                {{-- wire:click="openEditModal({{ $calculator->id }})" --}}

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false"
                                    x-transition
                                    x-cloak
                                    class="absolute right-0 mt-2 w-32 bg-white border rounded shadow z-10">
                                    
                                    <ul class="py-1 text-sm text-gray-700">
                                        <li>
                                            <button
                                                class="w-full flex flex-row items-center text-center text-left px-4 py-2 hover:bg-gray-100"
                                                wire:click="openEditModal({{ $calculator->id }}); open = false"
                                            >
                                            
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="1em" height="1em" fill="currentColor" class="bi bi-pencil-square me-2">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                                <span>
                                                    Edit
                                                </span>
                                            </button>
                                        </li>
                                        <li>
                                            <button
                                                wire:click="deleteCalculator({{ $calculator->id }})"
                                                class="w-full flex flex-row items-center text-left px-4 py-2 hover:bg-gray-100 text-red-600"
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="1em" height="1em" fill="currentColor" class="bi bi-trash3 me-3">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"></path>
                                            </svg>
                                                <span> Delete </span> 
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- end::modal -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-4">
            {{-- {{ $calculators->links() }} --}}
        </div>

        {{-- Edit Modal --}}
        @if($showEditModal && $activeCalculator)
            
            <div class="fixed  inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-[800px] p-6 text-black">
                    <h2 class="text-xl font-semibold text-black mb-4">Edit Calculator</h2>

                    <form wire:submit.prevent="save">
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Name</label>
                           
                                <input type="text" wire:model.defer="activeCalculator.title" class="w-full border rounded p-2" />
                                @error('activeCalculator.title') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Description</label>
                            <input type="text" wire:model.defer="activeCalculator.description" class="w-full border rounded p-2" />
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Settings Section - Only show if settings exist -->
                            @if(!empty($activeCalculator['settings']))
                                <div class="mb-4 p-4 border rounded bg-gray-50">
                                    <h3 class="font-medium mb-3">Calculator Settings</h3>
                                    
                                    
                                    @isset($activeCalculator['settings'])
                                        <div class="mb-3">
                                            <label class="block mb-1 font-medium">Enter Rate</label>
                                            <div class="flex items-center">
                                                <span class="mr-2">1 Robux =</span>
                                                <span class="mr-2">$</span>
                                                <input 
                                                    type="number" 
                                                    step="0.0001"
                                                    wire:model="activeCalculator.settings" 
                                                    class="w-32 border rounded p-2"
                                                />
                                            </div>
                                            @error('activeCalculator.settings.rate')
                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endisset

                                    <!-- Add more setting fields as needed -->
                                    {{-- @isset($activeCalculator['settings']['some_other_setting'])
                                        <div class="mb-3">
                                            <!-- Another setting field -->
                                        </div>
                                    @endisset --}}
                                </div>
                            @endif  
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="closeEditModal" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                            <button
                                type="submit"
                                wire:target="save"
                                wire:loading.attr="disabled"
                                class="px-4 py-2 bg-blue-600 text-white rounded flex items-center justify-center min-w-[90px]"
                            >
                                {{-- Normal Save text --}}
                                <span wire:loading.remove wire:target="save">Save</span>

                                {{-- Loading dots --}}
                                <span wire:loading wire:target="save" class="flex space-x-1">
                                    Save
                                    <span class="animate-bounce">.</span>
                                    <span class="animate-bounce delay-150">.</span>
                                    <span class="animate-bounce delay-300">.</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>


</div>
@push('styles')
    <style>
    .calculator-tabs button {
        padding: 8px 16px;
        margin-right: 8px;
        background: #f0f0f0;
        border: none;
        cursor: pointer;
    }
    .calculator-tabs button.active {
        background: #0d0e12;
        color: white;
    }
    .calculator-container {
        margin-top: 20px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }
</style>
@endpush
