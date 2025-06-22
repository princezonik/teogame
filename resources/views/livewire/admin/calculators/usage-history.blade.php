<div class="p-4 ml-[266px]">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Calculator Usage History</h2>

    <!-- Filters Section -->
    <div class="flex flex-wrap gap-4 mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search Calculators</label>
            <input type="text" wire:model.live.debounce.500ms="searchQuery" placeholder="Filter by name..." 
                   class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-200 focus:border-blue-400">
        </div>
        
        
        
        {{-- <div class="flex items-end">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors">
                Apply Filters
            </button>
        </div> --}}
    </div>

    <!-- Stats Bar -->
    <div class="mb-4 p-3 bg-blue-50 rounded-lg text-sm text-gray-700 flex justify-between items-center">
        <div>
            Showing <span class="font-bold">{{ $usages->count() }}</span> of 
            <span class="font-bold">{{ $usages->total() }}</span> records
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-1 bg-white border rounded-md text-sm flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Calculator</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Inputs</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date & Time</th>
                        {{-- <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th> --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($usages as $usage)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">
                                        {{ substr($usage->user->name ?? 'G', 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $usage->user->name ?? 'Guest' }}</div>
                                    <div class="text-sm text-gray-500">{{ $usage->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $usage->calculator->title ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">

                            {{-- <div class="text-sm text-gray-900 font-mono bg-gray-50 p-2 rounded">
                                <pre>{{ $usage->formatted_inputs }}</pre>
                            </div> --}}

                           <div class="text-sm text-gray-900 font-mono bg-gray-50 p-2 rounded">
                                @if(isset($usage->inputs))
                                    @if(is_array($usage->inputs))
                                        <ul class="list-disc pl-5">
                                            @foreach($usage->inputs as $key => $value)
                                                <li><span class="font-semibold">{{ $key }}:</span> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $usage->inputs }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </div>
                        </td>
                         <td class="px-6 py-4 whitespace-nowrap">
                            <div class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-lg bg-green-100 text-green-800">
                              
                                @if(isset($usage->result))
                                    @if(is_array($usage->result))
                                        <ul class="list-disc pl-5">
                                            @foreach($usage->result as $key => $value)
                                                <li><span class="font-semibold"></span> {{ $value }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $usage->result }}
                                    @endif
                                @else
                                    N/A
                                @endif

                            </div>
                        </td>
                      
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $usage->created_at->format('M d, Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $usage->created_at->format('h:i A') }}</div>
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-blue-600 hover:text-blue-900 mr-4">Details</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $usages->links() }}
        </div>
    </div>
</div>