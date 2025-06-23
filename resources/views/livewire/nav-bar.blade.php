<div x-data="{ open: @entangle('activeCalculator')}" 

    class="aside sidebar-dark flex flex-col  overflow-y-scroll fixed top-0 left-0 h-full z-[99]"
    :class="{'translate-x-0': $store.sidebar.open, '-translate-x-full lg:translate-x-0': !$store.sidebar.open}"
    style="width: 300px; transition: transform 0.3s ease;" >
    
    <!-- sidebar container with two sliding panel -->
    
    
    <div class="absolute h-[650px] w-[300px] overflow-hidden relative">
        <div :class="open ? '-translate-x-[50%]' : 'translate-x-0'"
              class="absolute inset-0 flex w-[200%] transform transition-transform duration-300 ease-in-out"
        >

        
            <!-- Calculator List Panel -->
            <div class="w-1/2 h-4/5 p-14"> 

                <button 
                    @click="$store.sidebar.open = false" 
                    class="lg:hidden text-white hover:text-gray-300 focus:outline-none"
                    title="Close Sidebar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <h2 class="text-lg font-bold mb-4 text-white"> Calculator Suite</h2>
                
                @foreach($calculators as $calc)
                    <button type="button" wire:click.prevent="toggleCalculator({{ $calc->id}})" class="block w-full text-left mb-2 menu-item p-2 "
                        > {{ $calc->title }}
                    </button>
                @endforeach
            </div>

            <!-- Bottom Auth Section -->
            <div class="absolute bottom-10 aside-footer   flex-column-auto px-9" id="kt_aside_footer">
                <!--begin::User panel-->
                <div class="d-flex flex-stack">
                    <!--begin::Wrapper-->
                    <div class="d-flex align-items-center">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-circle symbol-40px">
                            <img src="{{ Auth::check() ? asset('assets/media/avatars/300-1.jpg') : asset('assets/media/avatars/blank.png') }}" alt="photo" />
                        </div>
                        <!--end::Avatar-->
                        <!--begin::User info-->
                        <div class="ms-2">
                            <!--begin::Name-->
                            <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold lh-1">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</a>
                            <!--end::Name-->
                            <!--begin::Major-->
                            <span class="text-muted fw-semibold d-block fs-7 lh-1"> {{ Auth::check() ? Auth::user()->email : 'Not signed in' }}</span>
                            <!--end::Major-->
                        </div>
                        <!--end::User info-->
                    </div>
                    <!--end::Wrapper-->
                    <!--begin::User menu-->
                    <div class="ms-1">
                        <div class="btn btn-sm btn-icon btn-active-color-primary position-relative me-n2" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-overflow="true" data-kt-menu-placement="top-end">
                            <i class="ki-duotone ki-setting-2 fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--begin::User account menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="assets/media/avatars/300-1.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Username-->
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::check() ? Auth::user()->name : 'Guest' }}
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ Auth::check() ? 'user' : 'Guest' }}</span></div>
                                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::check() ? Auth::user()->email : 'Guest' }}</a>
                                    </div>
                                    <!--end::Username-->
                                </div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                           
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                          
                            <!--begin::Menu item-->
                            <div class="menu-item px-5 my-1">
                                <a href="{{route('profile.edit')}}" class="menu-link px-5">Account Settings</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                @if(Auth::check())
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="menu-link px-5 bg-transparent border-0">
                                            Sign Out
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="menu-link px-5">Sign In</a>
                                @endif
                            </div>
                            <!--end::Menu item-->
                        </div>
                    <!--end::User account menu-->
                </div>
                <!--end::User menu-->
                </div>
                <!--end::User panel-->
            </div>

            <!--calculator detail panel -->
            <div class="w-[300px]  p-4 overflow-y-auto">
                <button type="button" wire:click.prevent="backToList" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700  border border-gray-300 rounded-xl shadow-sm hover:text-white hover:bg-gray-800 hover:border-gray-800 transition-colors duration-300"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </button>
                @if($activeCalculator && $activeCalculator['slug'])
                    <div class="p-4 rounded shadow "> 
                        @livewire('calculator.' . $activeCalculator['slug'], [], key($activeCalculator['id']))
                    
                    </div>
                @endif
            </div>

        </div>
    </div>

    
</div>



@push('styles')
    <style>
        [x-cloak] {display: none !important;}
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


        
        /* Sidebar styles */
        .aside {
            background-color: #1e1e2d; /* Match Metronic sidebar color */
            box-shadow: 0 0 28px 0 rgb(82 63 105 / 5%);
        }
        
        /* Ensure main content adjusts when sidebar is open */
        @media (min-width: 992px) {
            .aside {
                position: relative;
                transform: translateX(0) !important;
            }
        }
        
        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 98;
            display: none;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
    </style>
@endpush