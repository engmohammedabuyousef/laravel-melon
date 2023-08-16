<x-default-layout>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <a href="/admin/customers/create" class="btn btn-primary">
                                Add User
                            </a>
                        </div>
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

        <script>
            // Get a reference to the "Add User" button
            const addButton = document.getElementById('add-user-button');

            // Add a click event listener to the button
            addButton.addEventListener('click', function() {
                // Navigate to the desired URL
                window.location.href = '/customers/create';
            });
        </script>

        {{-- <script src="{{ assets_url('admin') }}/js/users.js" type="text/javascript"></script> --}}
    @endpush

</x-default-layout>
