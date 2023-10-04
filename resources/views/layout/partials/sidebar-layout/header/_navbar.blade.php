<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
    <!--begin::Test menu-->
    {{-- <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
		<div class="cursor-pointer symbol symbol-70px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <div  class="symbol-label fs-3 bg-light-danger text-danger">
                {{ config()->get('settings.KT_THEME_DIRECTION') }}
            </div>
        </div>
        <!--end::Menu wrapper-->
    </div> --}}
    <!--end::Test menu-->

    <!--begin::Lang menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-70px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if (app()->getLocale() == 'ar')
                <a href="{{ route('en') }}" class="symbol-label fs-3 bg-light-primary text-primary">
                    {{ 'English' }}
                </a>
            @else
                <a href="{{ route('ar') }}" class="symbol-label fs-3 bg-light-primary text-primary">
                    {{ 'العربية' }}
                </a>
            @endif
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::Lang menu-->

    <!--begin::Notifications-->
    <div class="app-navbar-item ms-2 ms-lg-6">
        <!--begin::Menu wrapper-->
        <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative"
            id="kt_drawer_chat_toggle">
            <i class="ki-outline ki-notification-on fs-1"></i>
            <span
                class="position-absolute top-0 start-100 translate-middle  badge badge-circle badge-danger w-15px h-15px ms-n4 mt-3">
                5
            </span>
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::Notifications-->

    <!--begin::User menu-->
    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            @if (Auth::guard('admin')->user()->photo)
                <img src="{{ Auth::guard('admin')->user()->photo }}" class="rounded-3" alt="user" />
            @else
                <div
                    class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::guard('admin')->user()->name) }}">
                    {{ substr(Auth::guard('admin')->user()->name, 0, 1) }}
                </div>
            @endif
        </div>
        @include('partials/menus/_user-account-menu')
        <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->
</div>
<!--end::Navbar-->
