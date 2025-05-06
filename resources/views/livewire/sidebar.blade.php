<div class="  w-4/5 h-4/5 bg-[#f1f1f4] rounded-3xl flex flex-col justify-between shadow">
    <div>
        <div class="text-2xl font-bold mt-4 mb-4 ps-6 ">TeoGame</div>

        <!-- Dashboards -->
        <div class="p-6">
           <h1 class="font-bold">Dashboard</h1>
           
        </div>

        <div class="ps-6">

            
            <button wire:click="toggleCalculators" class="w-full text-left font-bold hover:text-yellow-400">
                Calculator
            </button>
        
            @if ($showCalculators)
                <ul class="pl-4 space-y-1">
                    @foreach ([
                        'gaming-session-electricity-cost-calculator' => 'Electricity Cost',
                        'loot-drop-chance' => 'Loot Drop Chance',
                        'ping-frame-delay' => 'Ping Delay',
                        'pixel-art-cost-estimator' => 'Pixel Art Cost',
                        'vram-fit-checker' => 'VRAM Checker',
                        'twitch-revenue-estimator' => 'Twitch Revenue',
                        'backlog-break-even-timer' => 'Backlog Timer',
                        'craft-vs-buy-roi-calculator' => 'Craft vs Buy ROI',
                        'exp-to-level' => 'EXP Needed',
                        'fps-budget-estimator' => 'FPS Estimator',
                        'currency-converter' => 'Robux/USD Converter',
                        'dps-ttk-calculator' => 'TTK Calculator',
                    ] as $key => $label)
                        <li>
                            <button wire:click="selectCalculator('{{ $key }}')" class=" text-[#4b5675] hover:text-[#192440]">
                                {{ $label }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
   
    </div>

    <!-- Footer Profile -->
    <div class="mt-8 flex items-center space-x-3 border-t pt-4">
        <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full" alt="avatar">
        <div class="text-sm">
            <div class="font-semibold">Guest</div>
            <div class="text-gray-500">Welcome to TeoGame</div>
        </div>
        <button class="ml-auto text-gray-400 hover:text-gray-600">⚙️</button>
    </div>
</div>
