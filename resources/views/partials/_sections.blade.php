@foreach ($menus as $menu)
        <?php
        $menu['permission'] = str_replace(' ', '', str_replace('and', '|', $menu['permission']));
        $menu['link'] = str_replace(' ', '', str_replace('and', '|', $menu['link']));
        $page = deleteAllBetween('/{', '}', Route::getFacadeRoot()->current()->uri());
        $permisson_now = \App\Models\Permission::where('link', request()->route()->getName())->first();

        if (isset($menu['id'])) {
            $permisson_list = \App\Models\Permission::where('id', $menu['id'])->first();
        }

        $is_true = 0;

        if (isset($permisson_now) && isset($permisson_list) && $permisson_now->id == $permisson_list->id || in_array(
                $permisson_now->id,
                $permisson_list->allChildren()->pluck('id')->toArray()
            )) {
            $is_true = 1;
        }
        ?>
    {{--
        <li class="menu-item menu-item-submenu @if ($is_true) menu-item-active menu-item-open @endif"
            aria-haspopup="true" data-menu-toggle="hover">
            <a href="{{ $menu['page'] }}" class="menu-link menu-toggle">
                <span class="menu-text">{{ $menu['title'] }}</span>
                @if (isset($menu['submenu']) && count($menu['submenu']) > 0)
                    <i class="menu-arrow"></i>
                @endif
            </a>
            @if (isset($menu['submenu']) && count($menu['submenu']) > 0)
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        @include('partials._sections', ['menus' => $menu['submenu'], 'isSub' => true])
                    </ul>
                </div>
            @endif
        </li>
    --}}

{{--    {{$menu['permission']}}--}}
        {{$page}}
{{--    {{$menu['link']}}--}}
    <div data-kt-menu-trigger="click"
         class="menu-item menu-accordion
{{--         {{ Illuminate\Support\Str::startsWith(request()->route()->getName(),['notifications'])? 'here show': '' }}--}}
{{ $is_true ? 'here show' : '' }}
         ">
        <!--begin:Menu link-->
        <span class="menu-link">
                    <span class="menu-icon">{!! getIcon('element-11', 'fs-2') !!}</span>
                    <span class="menu-title">{{ $menu['permission'] }}</span>


                            @if (isset($menu['submenu']) && count($menu['submenu']) > 0)
                <span class="menu-arrow"></span>
            @endif


                </span>
        <!--end:Menu link-->


        @if (isset($menu['submenu']) && count($menu['submenu']) > 0)

        <!--begin:Menu sub-->
        <div class="menu-sub menu-sub-accordion">
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                @include('partials._sections', ['menus' => $menu['submenu'], 'isSub' => true])

                {{--                <a class="menu-link {{ Illuminate\Support\Str::startsWith(request()->route()->getName(), ['notifications']) ? 'active': '' }}"--}}
{{--                   href="{{ route('notifications.create') }}">--}}
{{--                        <span class="menu-bullet">--}}
{{--                                <span class="bullet bullet-dot"></span>--}}
{{--                            </span>--}}
{{--                    <span class="menu-title">{{ $menu['permission'] }}</span>--}}
{{--                </a>--}}
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        </div>
        <!--end:Menu sub-->
        @endif


    </div>

@endforeach


{{--@if (isset($menu['submenu']) && count($menu['submenu']) > 0)--}}
{{--    <div class="menu-submenu">--}}
{{--        <i class="menu-arrow"></i>--}}
{{--        <ul class="menu-subnav">--}}
{{--            @include('partials._sections', ['menus' => $menu['submenu'], 'isSub' => true])--}}
{{--        </ul>--}}
{{--    </div>--}}
{{--@endif--}}
