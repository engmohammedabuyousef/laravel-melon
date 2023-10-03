<x-default-layout>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Toolbar-->
                <div class="m-4 d-flex justify-content-between align-items-center">
                    <h3>{{ $title }}</h3>
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="/admin/roles/create" class="btn btn-primary">
                            {{ __('dashboard.add_role') }}
                        </a>
                    </div>
                </div>
                <!--end::Toolbar-->

                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-body">
                        <!--begin::Search Form-->
                        {{--  --}}
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
