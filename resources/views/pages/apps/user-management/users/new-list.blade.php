<x-default-layout>
<div>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">

                    {{-- <div class="card-toolbar">
                        <!--begin::Button-->
                        <a href="{{ url(admin_user_url() . '/create') }}"
                            class="btn btn-primary font-weight-bolder add-new-mdl">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <circle fill="#000000" cx="9" cy="15" r="6" />
                                        <path
                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                            fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
											</span>{{ __('admin.Add New') }}</a>
                        <!--end::Button-->
                    </div> --}}
                </div>
                <div class="card-body">
                    <!--begin::Search Form-->

                    <!--end::Search Form-->
                    <!--end: Search Form-->
                    <!--begin: Datatable-->
                    <div class="portlet-body">

                        <table class="table table-separate table-head-custom collapsed" id="users_tbl">
                            <thead>

                                <tr>
                                    {{-- <th title="Field #1">#</th> --}}
                                    {{-- <th title="{{ __('admin.Photo') }}">{{ __('admin.Photo') }}</th> --}}
                                    <th title="{{ __('admin.Name') }}">{{ __('admin.Name') }}</th>
                                    {{-- <th title="{{ __('admin.Email') }}">{{ __('admin.Email') }}</th>
                                    <th title="{{ __('admin.Last Login') }}">{{ __('admin.Last Login') }}</th>
                                    <th title="{{ __('admin.Registered date') }}">{{ __('admin.Registered date') }}</th>
                                    <th title="{{ __('admin.Is active') }}">{{ __('admin.Is active') }}</th>
                                    <th title="{{ __('admin.Action') }}">{{ __('admin.Action') }}</th> --}}
                                </tr>
                            </thead>

                        </table>
                    </div>


                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div></div>

    @push('scripts')
    <script src="{{ assets_url('admin') }}/js/users.js" type="text/javascript"></script>
    @endpush

</x-default-layout>
