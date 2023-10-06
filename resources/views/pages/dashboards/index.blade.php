<x-default-layout>
    @if(authAdmin()->hasPermissionTo('dashboard'))
        <div class="row g-5 g-xl-8">
            <div class="col-xl-3">
                <a href="#" class="card bg-info hoverable card-m-stretch mb-5 mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="text-white fw-bold fs-2 mb-2 mt-2">{{ $admins_count }}</div>
                        <div class="fw-semibold text-white">Admins</div>
                    </div>
                    <!--end::Body-->
                </a>
            </div>

            <div class="col-xl-3">
                <a href="#" class="card bg-warning hoverable card-m-stretch mb-xl-8">
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="text-white fw-bold fs-2 mb-2 mt-2">{{ $users_count }}</div>
                        <div class="fw-semibold text-white">Users</div>
                    </div>
                    <!--end::Body-->
                </a>
            </div>
        </div>
    @else
        <div>Welcome</div>
    @endif
</x-default-layout>
