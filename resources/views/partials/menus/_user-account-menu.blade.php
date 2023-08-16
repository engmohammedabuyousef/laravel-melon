<!--begin::User account menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
    data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--begin::Avatar-->
            <div class="symbol symbol-50px me-5">
                @if (Auth::guard('admin')->user()->photo)
                    <img alt="Logo" src="{{ Auth::guard('admin')->user()->photo }}" />
                @else
                    <div
                        class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::guard('admin')->user()->name) }}">
                        {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <!--end::Avatar-->
            <!--begin::Username-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::guard('admin')->user()->name }}</div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::guard('admin')->user()->email }}</a>
            </div>
            <!--end::Username-->
        </div>
    </div>
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    {{-- <div class="separator my-2"></div> --}}
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    {{-- <div class="menu-item px-5">
        <a href="#" class="menu-link px-5">{{ __('My Profile') }}</a>
    </div> --}}
    <!--end::Menu item-->

    <!--begin::Menu separator-->
    <div class="separator my-2"></div>
    <!--end::Menu separator-->

    <!--begin::Menu item-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post"
            data-csrf="{{ csrf_token() }}" data-reload="true">
            {{ __('Sign Out') }}
        </a>
    </div>
    <!--end::Menu item-->
</div>
<!--end::User account menu-->
