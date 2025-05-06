{{-- <div>
    @if ($activePage === 'dashboard')
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p>Welcome to your dashboard.</p>
    @elseif ($activePage === 'calculator')
        <h1 class="text-2xl font-bold">Calculator</h1>
        <p>Here is the calculator interface.</p>
    @elseif ($activePage === 'leaderboard')
        <h1 class="text-2xl font-bold">Leaderboard</h1>
        <p>Leaderboard content goes here.</p>
    @elseif ($activePage === 'settings')
        <h1 class="text-2xl font-bold">Settings</h1>
        <p>Settings panel loaded.</p>
    @endif
</div> --}}

<!-- resources/views/livewire/dashboard-page.blade.php -->
<div>
    {{-- @if ($page === 'dashboard')
        <h1 class="text-2xl font-bold mb-4">Welcome to your dashboard</h1>
    @elseif ($page === 'calculator')
        <h2 class="text-xl font-semibold mb-4">Calculator Tools</h2>
        <div class="grid grid-cols-3 gap-4"> --}}
            {{-- <a href="{{ route('convert') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Robux to USD</a>
            <a href="{{ route('ttk.calculate') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">TTK Calculator</a>
            <a href="{{ route('lootdrop.calculate') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Loot Drop Simulator</a>
            <a href="{{ route('steam_backlog.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Steam Backlog</a>
            <a href="{{ route('exp.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">EXP Calculator</a>
            <a href="{{ route('sprite.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Sprite Cost Estimator</a>
            <a href="{{ route('vram.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">VRAM Checker</a>
            <a href="{{ route('craft.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Craft ROI</a>
            <a href="{{ route('electricity.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Electricity Cost</a>
            <a href="{{ route('twitch.form') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">Twitch Revenue</a>
            <a href="{{ url('/tools/estimate-fps') }}" class="p-4 bg-white shadow hover:bg-gray-100 rounded">FPS Estimator</a> --}}

            {{-- @livewire('calculator.robux-to-usd') --}}
            {{-- @livewire('calculator.craft-roi') --}}
            {{-- <livewire:dps-ttk-calculator />
            <livewire:loot-drop-chance />
            <livewire:backlog-break-even-timer />
            <livewire:fps-budget-estimator />
            <livewire:ping-frame-delay />
            <livewire:exp-to-level />
            <livewire:pixel-art-cost-estimator />
            <livewire:twitch-revenue-estimator />
            <livewire:vram-fit-checker />
            <livewire:craft-vs-buy-roi-calculator />
            <livewire:gaming-session-electricity-cost-calculator /> --}}




        {{-- </div>
    @elseif ($page === 'leaderboard')
        <h2 class="text-xl font-semibold">Leaderboard content goes here</h2>
    @elseif ($page === 'settings')
        <h2 class="text-xl font-semibold">Settings content goes here</h2>
    @endif --}}
</div>
