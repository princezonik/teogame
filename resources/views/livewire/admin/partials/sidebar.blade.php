<div>
    <div 
      
        x-transition
        class="app-sidebar "
        
        style="width: 265px; background-color: #0d0e12; height: 100vh; position: fixed; left: 0; top: 0;">
        <!-- Sidebar Header -->
        <div class="sidebar-header" style="padding: 20px 0 0 20px; margin-bottom: 30px;">
            <h2 style="color: #fff; font-size: 1.5rem; font-weight: 600; margin: 0;">Teogame</h2>

            <!-- X button for mobile -->
    {{-- <button @click="$store.adminSidebar.close()" class="lg:hidden text-white hover:text-gray-400 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button> --}}
        </div>

        <!-- Menu Wrapper -->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper" style="height: calc(100% - 80px); overflow: hidden;">
            <!-- Scroll Wrapper -->
            <div
                id="kt_app_sidebar_menu_scroll"
                class="scroll-y my-5 mx-3"
                data-kt-scroll="true"
                data-kt-scroll-activate="true"
                data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu"
                data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true"
                style="max-height: 100%;">
                <!-- Menu -->
                <div 
                    class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6"
                    id="#kt_app_sidebar_menu"
                    data-kt-menu="true"
                    data-kt-menu-expand="false">
                    
                    
                    <!-- Dashboard Menu Item -->
                    <div data-kt-menu-trigger="click" class="menu-item here show menu-accordion text-[#9a9cae]">
                        <!-- Menu Link -->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2" style="color: #8898aa;">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title text-white">Dashboards</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!-- Menu Sub -->
                        <div class="menu-sub menu-sub-accordion">
                            <!-- Default Dashboard -->
                            <div class="menu-item">
                                <a class="menu-link active" href="{{ route('admin.dashboard') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot" style="background-color: #8898aa;"></span>
                                    </span>
                                    <span class="menu-title text-[#8898aa] transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300' }}" >Default</span>
                                </a>
                            </div>
                            
                           
                            <div class="menu-item here show menu-accordion" data-kt-menu-trigger="click">
                                <!-- Main Calculator Menu Link -->
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="fas fa-calculator" style="color: #8898aa; font-size: 1.5rem;"></i>
                                    </span>
                                    <span class="menu-title" style="color:#9a9cae;;">Calculators</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                
                                <!-- Submenu -->
                                <div class="menu-sub menu-sub-accordion">
                                    <!-- All Calculators -->
                                    <div class="menu-item">
                                        <a wire:navigate href="{{ route('admin.calculators') }}" 
                                        class="menu-link hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.calculators') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot {{ request()->routeIs('admin.calculators') ? 'bg-white' : 'bg-gray-400' }}"></span>
                                            </span>
                                            <span class="menu-title">All Calculators</span>
                                        </a>
                                    </div>
                                    
                                    <!-- Calculator History -->
                                    <div class="menu-item">
                                        <a wire:navigate href="{{route('admin.usage.history')}}" 
                                        class="menu-link hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.usage.history') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot {{ request()->routeIs('admin.usage.history') ? 'bg-white' : 'bg-gray-400' }}"></span>
                                            </span>
                                            <span class="menu-title">Usage History</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Leaderboard -->
                            <div class="menu-item">
                                <a class="menu-link hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.leaderboard') ? 'bg-gray-700 text-white' : 'text-gray-300' }}" href="{{ route('admin.leaderboard') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-trophy" style="color: #8898aa;"></i>
                                    </span>
                                    <span class="menu-title" style="color: #fff;">Leaderboard</span>
                                </a>
                            </div> 

                            <!-- Manage Puzzles -->
                            <div class="menu-item">
                                <a class="menu-link hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.manage.puzzle') ? 'bg-gray-700 text-white' : 'text-gray-300' }}" href="{{ route('admin.manage.puzzle') }}">
                                    <span class="menu-icon">
                                        <i class="fas fa-puzzle-piece" style="color: #8898aa;"></i>
                                    </span>
                                    <span class="menu-title" style="color: #fff;">Manage Puzzles</span>
                                </a>
                            </div> 

                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Main Content Area -->
    <div class="main-content" style="margin-left: 265px; padding: 20px;">
       <livewire:admin.calculators.calculators />
    </div> --}}

</div>

@push('styles')
    <style>
        /* Base Styles */
        .app-sidebar {
            --kt-app-sidebar-width: 265px;
            --kt-menu-link-bg-color-active: #1a1a27;
            --kt-menu-link-color-active: #fff;
        }
        
        /* Menu Styles */
        .menu-link {
            padding: 12px 15px;
            transition: all 0.3s ease;
            border-radius: 6px;
            margin-bottom: 2px;
        }
        
        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .menu-link.active {
            background-color: var(--kt-menu-link-bg-color-active);
            color: var(--kt-menu-link-color-active);
        }
        
        .menu-title {
            transition: all 0.3s ease;
        }
        
        .menu-icon {
            margin-right: 10px;
        }
        
        .menu-arrow {
            transition: all 0.3s ease;
        }
        
        /* Scrollbar Styles */
        .scroll-y::-webkit-scrollbar {
            width: 4px;
        }
        
        .scroll-y::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
    </style>
@endpush