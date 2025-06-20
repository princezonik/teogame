
<div
    x-data="{
        loading: true,
        init() {
            // Call Livewire method from Alpine
            this.$wire.loadGame('{{ $games->slug ?? '' }}');
            
            this.$wire.on('game-loaded', (payload) => {
                window.gameId = payload.gameId;
                window.currentGameSlug = payload.slug;

                if (typeof initializeEcho === 'function') {
                    initializeEcho();
                }

                this.loading = false;
            });

            this.$wire.on('setGameId', (payload) => {
                window.gameId = payload.gameId;
                window.currentGameSlug = payload.slug;
                console.log('setGameId received:', payload);
                if (typeof initializeEcho === 'function') {
                    initializeEcho();
                }
            });
        }
    }"
    class="flex flex-col h-screen w-1/2 mx-auto p-[50px] "
  
>
    <!--begin::Header-->
    <div id="kt_header" class="header mt-0 mt-lg-0 pt-lg-0 " data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{lg: '300px'}">
        <!--begin::Container-->
        <div class="container d-flex flex-stack flex-wrap gap-4 transparent" id="kt_header_container">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column align-items-start justify-content-center flex-wrap me-lg-2 pb-10 pb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', lg: '#kt_header_container'}">
                <!--begin::Heading-->
                <h1 class="d-flex flex-column text-gray-900 fw-bold my-0 fs-1">Hello, {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                <small class="text-muted fs-6 fw-semibold pt-1">Your daily quest awaits!</small></h1>
                <!--end::Heading-->
            </div>
            <!--end::Page title=-->
            <!--begin::Wrapper-->
            <div class="d-flex d-lg-none align-items-center ms-n3 me-2">
                <!--begin::Aside mobile toggle-->
                <div class="btn btn-icon btn-active-icon-primary" id="kt_aside_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-1 mt-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Aside mobile toggle-->
                <!--begin::Logo-->
                <a href="index.html" class="d-flex align-items-center">
                    <img alt="Logo" src="assets/media/logos/demo3.svg" class="theme-light-show h-20px" />
                    <img alt="Logo" src="assets/media/logos/demo3-dark.svg" class="theme-dark-show h-20px" />
                </a>
                <!--end::Logo-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-center flex-shrink-0 mb-0 mb-lg-0">
                <!--begin::Search-->
                <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-250px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="lg" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
                    <!--begin::Tablet and mobile search toggle-->
                    <div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
                        <div class="d-flex btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px">
                            <i class="ki-duotone ki-magnifier fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <!--end::Tablet and mobile search toggle-->
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-2 mb-lg-0" autocomplete="off">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        
                        <!--begin::Input-->
                        <input type="text" class="form-control bg-transparent ps-13 fs-7 h-40px" name="search" value="" placeholder="Quick Search" data-kt-search-element="input" />
                        <!--end::Input-->
                        
                    
                    </form>
                    <!--end::Form-->
                    
                </div>
                <!--end::Search-->
                <!--begin::Activities-->
                <div class="d-flex align-items-center ms-3 ms-lg-4">
                    <!--begin::Drawer toggle-->
                    <div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px" id="kt_activities_toggle">
                        <i class="ki-duotone ki-notification-bing fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                    <!--end::Drawer toggle-->
                </div>
                <!--end::Activities-->
                <!--begin::Chat-->
                <div class="d-flex align-items-center ms-3 ms-lg-4">
                    <!--begin::Drawer wrapper-->
                    <div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px position-relative" id="kt_drawer_chat_toggle">
                        <i class="ki-duotone ki-message-text-2 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <!--begin::Bullet-->
                        <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
                        <!--end::Bullet-->
                    </div>
                    <!--end::Drawer wrapper-->
                </div>
                <!--end::Chat-->
                <!--begin::Theme mode-->
                <div class="d-flex align-items-center ms-3 ms-lg-4">
                    <!--begin::Menu toggle-->
                    <a href="#" class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day theme-light-show fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                        <i class="ki-duotone ki-moon theme-dark-show fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                    <!--begin::Menu toggle-->
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-night-day fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                        <span class="path7"></span>
                                        <span class="path8"></span>
                                        <span class="path9"></span>
                                        <span class="path10"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Light</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-moon fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="menu-title">Dark</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3 my-0">
                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                <span class="menu-icon" data-kt-element="icon">
                                    <i class="ki-duotone ki-screen fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="menu-title">System</span>
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Theme mode-->
                <!--begin::Sidebar Toggler-->
                <div class="d-flex align-items-center d-xxl-none ms-3 ms-lg-4">
                    <div class="btn btn-icon btn-color-gray-700 btn-active-color-primary btn-outline w-40px h-40px position-relative" id="kt_sidebar_toggler">
                        <i class="ki-duotone ki-burger-menu-2 fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                    </div>
                </div>
                <!--end::Sidebar Toggler-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->

    @if($games)
        
        <!-- Loading state -->
        <div x-show="loading" class="text-center mt-[50px]   ">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-white mx-auto "></div>
            {{-- <p class="mt-2">Loading game...</p> --}}
        </div>

        <!-- Game content -->
        <div id="game_wrapper" x-data x-cloak x-show="!loading" class=" flex transition-opacity duration-300 mt-[100px] justify-center items-center">
            @php
                $componentExists = View::exists('livewire.' . $games->slug);
            @endphp

            @if($componentExists)
                @livewire($games->slug, ['game' => $games], key($games->id))
            @else
                <p class="text-red-600 text-center py-8">Game component "{{ $games->slug }}" not found.</p>
            @endif
        </div>
    
    @else
        <p class="text-center py-8">No game available today.</p>
    @endif
</div>
@push('styles')
    <style>
        .transparent{
            background-color: transparent !important;
        }

        [x-cloak] { 
            display: none !important; 
        }
    </style>
@endpush