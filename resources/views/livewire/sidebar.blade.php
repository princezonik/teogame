<div id="kt_aside" class="aside py-9" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle" style="overflow-y: auto">
	<!--begin::Brand-->
	<div class="aside-logo flex-column-auto px-9 mb-9" id="kt_aside_logo">
		<!--begin::Logo-->
		<a href="index.html">
			<h1 class="font-bold text-[34px]">Teogame</h2>
			{{-- <img alt="Logo" src="assets/media/logos/demo3.svg" class="h-20px logo theme-light-show" />
			<img alt="Logo" src="assets/media/logos/demo3-dark.svg" class="h-20px logo theme-dark-show" /> --}}
		</a>
		<!--end::Logo-->
	</div>
	<!--end::Brand-->

	<!--begin::Aside menu-->
	<div  x-data="{ open: @entangle('activeCalculator')}"class="overflow:hidden aside-menu flex-column-fluid ps-5 pe-3 mb-9" id="kt_aside_menu">
		<!--begin::Aside Menu-->
		<div class="w-100 hover-scroll-overlay-y d-flex pe-3" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu, #kt_aside_menu_wrapper" data-kt-scroll-offset="100">
			<!--begin::Menu-->
			<div class="menu menu-column menu-rounded menu-sub-indention menu-active-bg fw-semibold my-auto" id="#kt_aside_menu" data-kt-menu="true">
				<!--begin:Menu item-->
				<div data-kt-menu-trigger="click" class="menu-item here show menu-accordion">
					<!--begin:Menu link-->
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-black-right fs-2"></i>
						</span>
						<span class="menu-title">Dashboards</span>
						<span class="menu-arrow"></span>
					</span>
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					<div class="menu-sub menu-sub-accordion">
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link active" href="index.html">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Default</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->
						<!--begin:Menu item-->
						<div class="menu-item">
							<!--begin:Menu link-->
							<a class="menu-link" href="{{route('games.index')}}">
								<span class="menu-bullet">
									<span class="bullet bullet-dot"></span>
								</span>
								<span class="menu-title">Games</span>
							</a>
							<!--end:Menu link-->
						</div>
						<!--end:Menu item-->

						
					</div>
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->
				<!--begin:Menu item-->
				<div  data-kt-menu-trigger="click" class="menu-item menu-accordion">
					
					<!--end:Menu link-->
					<!--begin:Menu sub-->
					{{-- <div class="menu-sub menu-sub-accordion" wire:ignore.self> --}}
						<!--begin:Menu item-->
						<div data-kt-menu-trigger="click" class="menu-item menu-accordion"
							<!--begin:Menu link-->
							<span class="menu-link">
								<span class="menu-icon">
									<i class="ki-duotone ki-black-right fs-2"></i>
								</span>
								<span class="menu-title">Calculator Suite</span>
								<span class="menu-arrow"></span>
							</span>
							<!--end:Menu link-->
							
							<!--begin:Menu sub-->

							
							<div class="menu-sub menu-sub-accordion" wire:ignore.self>
								@foreach($calculators as $calculator)
									<!--begin:Menu item-->
									<div wire:ignore.self class="menu-item @if($activeCalculator === $calculator->id) menu-item-open @endif">
										<!--begin:Menu link-->
										<a 
											class="menu-link @if($activeCalculator === $calculator->id) active @endif"" href="#" 
											wire:click.prevent="toggleCalculator({{$calculator->id}})"
											wire:ignore.self
										>
											
											<span class="menu-bullet">
												<span class="bullet bullet-dot"></span>
											</span>
											<span class="menu-title">{{$calculator->title}}</span>
										</a>

										<div class="livewire-slide-in"  wire:ignore.self>
											@if($activeCalculator === $calculator->id)
												@livewire('calculator.'. $calculator->slug, key('calculator-' . $calculator->id))
											@endif
										</div>
										
										<!--end:Menu link-->
									</div>

									
									<!--end:Menu item-->
								@endforeach
							</div>
							
							<!--end:Menu sub-->
						</div>
						<!--end:Menu item-->
				
						
					{{-- </div> --}}
					<!--end:Menu sub-->
				</div>
				<!--end:Menu item-->
				
			</div>
			<!--end::Menu-->
		</div>
		<!--end::Aside Menu-->
	</div>
	<!--end::Aside menu-->
	<!--begin::Footer-->
	<div class="aside-footer flex-column-auto px-9" id="kt_aside_footer">
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
	<!--end::Footer-->
</div>
@push('styles')
    <style>
        .livewire-slide-in {
            animation: slideIn 0.6s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0%);
                opacity: 1;
            }
        }

    </style>  
@endpush