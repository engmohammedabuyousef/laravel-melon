@foreach ($menus as $menu)
        <?php
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

    <div data-kt-menu-trigger="click"
         class="menu-item menu-accordion
         {{ Illuminate\Support\Str::startsWith(request()->route()->getName(),[ $menu['permission'] ])? 'here show': '' }}">
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
                    @include('partials._sections', ['menus' => $menu['submenu'], 'isSub' => true])
                </div>
                <!--end:Menu item-->
            </div>
            <!--end:Menu sub-->
        @endif
    </div>
@endforeach
