<div class="absolute top-[50px] left-[50px] w-64 flex flex-col z-20 h-4/5 rounded-4xl bg-[#F1F1F4] shadow-lg rounded-r-lg">
        <nav class="flex flex-col flex-1 w-full p-4 overflow-y-auto">
            <h1 class="flex-grow-0 text-2xl font-bold text-gray-800 mb-6">Teogame</h1>
            <div class="relative">
                <button id="gamesDropdown" class="flex-grow-0 w-full text-left text-gray-700 hover:text-blue-500 py-2">
                    All Games
                </button>
                <div id="gamesDropdownMenu" class="dropdown-menu mt-1 w-full bg-[#F1F1F4]  p-2">
                    <ul class="space-y-1">
                        <li class="flex items-center">
                            <span class="mr-2">🎲</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Dice Dash</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-2">🃏</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Card Quest</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-2">🧩</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Puzzle Master</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-2">⚔️</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Knight's Arena</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-2">🏰</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Castle Siege</a>
                        </li>
                        <li class="flex items-center">
                            <span class="mr-2">🚗</span>
                            <a href="#" class="text-gray-800 hover:text-blue-500">Race Riser</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Bottom Auth Section -->
            <div class="mt-auto flex items-center p-4 border-t border-gray-200">
                <img src="{{ asset('images/profile.png')}}" class="w-10 h-10 rounded-full mr-2">
                <div>
                    @if(Auth::check())
                        <div class="text-sm text-gray-700">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->role ?? 'Player' }}</div>
                    @else
                        <div class="text-sm text-gray-700">Guest</div>
                        
                    @endif
                </div>

                <div class="ml-auto">

                    @auth
                        <!-- Logout Form -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-md bg-red-500 text-white hover:bg-red-600 text-sm">
                                Logout
                            </button>
                        </form>
                    @else
                        <!-- Login Dropdown -->
                        <button  onclick="window.location='{{ route('login') }}';" class="flex items-center gap-2 px-4 py-2 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition duration-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Log In
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                      
                    @endauth
                </div>
            </div>
        </nav>
    </div>


@push('scripts')
    <script>
        // Toggle dropdown menus
        document.addEventListener('DOMContentLoaded', function () {
            const loginDropdownButton = document.querySelector('#loginDropdown');
            const loginDropdownMenu = document.querySelector('#loginDropdownMenu');
            const gamesDropdownButton = document.querySelector('#gamesDropdown');
            const gamesDropdownMenu = document.querySelector('#gamesDropdownMenu');

            // Toggle login dropdown
            loginDropdownButton.addEventListener('click', function (e) {
                e.stopPropagation();
                loginDropdownMenu.classList.toggle('show');
                gamesDropdownMenu.classList.remove('show'); // Close games dropdown if open
            });

            loginDropdownMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            // Toggle games dropdown
            gamesDropdownButton.addEventListener('click', function (e) {
                e.stopPropagation();
                gamesDropdownMenu.classList.toggle('show');
                loginDropdownMenu.classList.remove('show'); // Close login dropdown if open
            });

            gamesDropdownMenu.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            // Close both dropdowns when clicking outside
            document.addEventListener('click', function () {
                if (loginDropdownMenu.classList.contains('show')) {
                    loginDropdownMenu.classList.remove('show');
                }
                if (gamesDropdownMenu.classList.contains('show')) {
                    gamesDropdownMenu.classList.remove('show');
                }
            });
        });
    </script>  
@endpush

@push('styles')
    <style>
        /* Ensure dropdowns stay visible when interacting with the form */
        .dropdown-menu {
            display: none;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .dropdown-menu.show {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
@endpush