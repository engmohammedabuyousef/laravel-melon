<x-default-layout>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar m-4">
                        <!--begin::Title-->
                        <div class="m-4 d-flex justify-content-between align-items-center">
                            <h3>{{ $title }}</h3>
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <a href="/admin/admins/create" class="btn btn-primary">
                                    {{ __('dashboard.add_admin') }}
                                </a>
                            </div>
                        </div>
                        <!--end::Title-->
                        <!--begin::Toolbar-->

                        <!--end::Toolbar-->

                        <!--begin::Modal-->
                        {{-- <livewire:user.add-user-modal></livewire:user.add-user-modal> --}}
                        <!--end::Modal-->
                    </div>
                    <!--end::Card toolbar-->
                    <div class="card-body">
                        <!--begin::Search Form-->

                        <!--end::Search Form-->
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
