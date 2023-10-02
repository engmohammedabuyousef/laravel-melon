<x-default-layout>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Toolbar-->
                <div class="m-4 d-flex justify-content-between align-items-center">
                    <h3>{{ $title }}</h3>
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="/admin/users/create" class="btn btn-primary">
                            {{ __('dashboard.add_user') }}
                        </a>
                    </div>
                </div>
                <!--end::Toolbar-->
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Search Form-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                        class="path1"></span><span class="path2"></span></i> <input type="text"
                                    data-kt-user-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Search user">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end: Search Form-->

                        <!--begin: Datatable-->
                        <div class="portlet-body">
                            {{ $dataTable->table() }}
                        </div>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
    </div>

    @push('scripts')
        {{ $dataTable->scripts() }}
    @endpush

</x-default-layout>
