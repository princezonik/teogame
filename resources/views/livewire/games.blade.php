
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
        <div class="container mx-auto d-flex flex-stack flex-wrap gap-4 transparent" id="kt_header_container">
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
                <div @click="$store.sidebar.toggle()" class="btn btn-icon btn-active-icon-primary" >
                    <i class="ki-duotone ki-abstract-14 fs-1 mt-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            
                <!--end::Logo-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Topbar-->
            <div class="d-flex align-items-center flex-shrink-0 mb-0 mb-lg-0">
               
                
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