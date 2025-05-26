<div x-data="{ open: @entangle('activeCalculator')}" class=" absolute h-[650px] flex flex-col overflow:hidden bg-[#f1f1f1] w-[300px] mt-[40px] ml-[50px] mb-[40px] pb-[20px] rounded-bl-[30px] rounded-tl-[30px]" >
    
    <!-- sidebar container with two sliding panel -->
    
    <div class="absolute h-[650px] w-[300px] overflow-hidden">
        <div :class="open ? '-translate-x-[50%]' : 'translate-x-0'"
              class="absolute inset-0 flex w-[200%] transform transition-transform duration-300 ease-in-out"
        >
            <!-- Calculator List Panel -->
            <div class="w-1/2 h-4/5 text-[#546182] p-14"> 
                <h2 class="text-lg font-bold mb-4 text-white"> Calculator Suite</h2>
                @foreach($calculators as $calc)
                    <button type="button" wire:click.prevent="toggleCalculator({{ $calc->id}})" class="block w-full text-left mb-2 hover:text-black p-2 "
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
                                        <div class="fw-bold d-flex align-items-center fs-5">Max Smith 
                                        <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span></div>
                                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">max@kt.com</a>
                                    </div>
                                    <!--end::Username-->
                                </div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="account/overview.html" class="menu-link px-5">My Profile</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="apps/projects/list.html" class="menu-link px-5">
                                    <span class="menu-text">My Projects</span>
                                    <span class="menu-badge">
                                        <span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                                    </span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                                <a href="#" class="menu-link px-5">
                                    <span class="menu-title">My Subscription</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <!--begin::Menu sub-->
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/referrals.html" class="menu-link px-5">Referrals</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/billing.html" class="menu-link px-5">Billing</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/statements.html" class="menu-link px-5">Payments</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/statements.html" class="menu-link d-flex flex-stack px-5">Statements 
                                        <span class="ms-2 lh-0" data-bs-toggle="tooltip" title="View your statements">
                                            <i class="ki-duotone ki-information-5 fs-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span></a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu separator-->
                                    <div class="separator my-2"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content px-3">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
                                                <span class="form-check-label text-muted fs-7">Notifications</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu sub-->
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="account/statements.html" class="menu-link px-5">My Statements</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu separator-->
                            <div class="separator my-2"></div>
                            <!--end::Menu separator-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="right-end" data-kt-menu-offset="-15px, 0">
                                <a href="#" class="menu-link px-5">
                                    <span class="menu-title position-relative">Language 
                                    <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English 
                                    <img class="w-15px h-15px rounded-1 ms-2" src="assets/media/flags/united-states.svg" alt="" /></span></span>
                                </a>
                                <!--begin::Menu sub-->
                                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/settings.html" class="menu-link d-flex px-5 active">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
                                        </span>English</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/settings.html" class="menu-link d-flex px-5">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
                                        </span>Spanish</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/settings.html" class="menu-link d-flex px-5">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
                                        </span>German</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/settings.html" class="menu-link d-flex px-5">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
                                        </span>Japanese</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="account/settings.html" class="menu-link d-flex px-5">
                                        <span class="symbol symbol-20px me-4">
                                            <img class="rounded-1" src="assets/media/flags/france.svg" alt="" />
                                        </span>French</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu sub-->
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5 my-1">
                                <a href="account/settings.html" class="menu-link px-5">Account Settings</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="authentication/layouts/corporate/sign-in.html" class="menu-link px-5">Sign Out</a>
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
            <div class="w-[300px] bg-[#192440] text-white p-4 overflow-y-auto">
                <button type="button" wire:click.prevent="backToList" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:text-white hover:bg-gray-800 hover:border-gray-800 transition-colors duration-300"> 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back
                </button>
                @if($activeCalculator && $activeCalculator['slug'])
                    <div class="text-black p-4 rounded shadow"> 
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
    </style>
@endpush