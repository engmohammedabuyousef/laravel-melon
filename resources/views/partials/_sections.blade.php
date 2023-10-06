@foreach ($menus as $menu)
        <?php
        $menu['name'] = $menu['permission'];
        $menu['permission'] = ucwords($menu['permission']);
        $page = deleteAllBetween('/{', '}', Route::getFacadeRoot()->current()->uri());
        $currentPermission = \App\Models\Permission::where('link', request()->route()->getName())->first();

        if (isset($menu['id'])) {
            $permisson = \App\Models\Permission::where('id', $menu['id'])->first();
        }

        $isTrue = 0;

        if (isset($currentPermission) && isset($permisson_list) && $currentPermission->id == $permisson->id || in_array(
                $currentPermission->id,
                $permisson->allChildren()->pluck('id')->toArray()
            )) {
            $isTrue = 1;
        }
        ?>

    @if($menu['link'] != '#')
        <a href="{{route($menu['link'])}}">
            @endif
            <div data-kt-menu-trigger="click"
                 class="menu-item menu-accordion
         {{ $permisson['parent_id'] == $menu['parent_id'] ? 'here show': '' }}">
                <!--begin:Menu link-->
                @if($menu['link'] != '#')
                    <a href="{{route($menu['link'])}}">
                        @endif
                        <span
                            class="menu-link {{ Illuminate\Support\Str::startsWith(request()->route()->getName(),[ $menu['name'] ])? 'active': '' }}">
                    @if($permisson['parent_id'] == 0 )
                                <span class="menu-icon">{!! getIcon($permisson['icon'], 'fs-2') !!}</span>
                            @else
                                <span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
                            @endif
                    <span class="menu-title">{{ $menu['permission'] }}</span>
                    @if (isset($menu['submenu']) && count($menu['submenu']) > 0)
                                <span class="menu-arrow"></span>
                            @endif
                </span>
                        @if($menu['link'] != '#')
                    </a>
                @endif
                <!--end:Menu link-->

                @if (isset($menu['submenu']) && count($menu['submenu']) > 0)
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            @include('partials._sections', ['menus' => $menu['submenu'], 'isSub' => true])
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                @endif
            </div>
            @if($menu['link'] != '#')
        </a>
    @endif

@endforeach
