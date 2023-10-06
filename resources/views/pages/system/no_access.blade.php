<!--begin::Card body-->
<div class="card-body py-15 py-lg-20">

    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('{{ image('auth/bg1.jpg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ image('auth/bg1-dark.jpg') }}');
        }
    </style>
    <!--end::Page bg image-->

    <!--begin::Title-->
    <h1 class="fw-bolder fs-2hx text-gray-900 mb-4">
        403
    </h1>
    <!--end::Title-->

    <!--begin::Text-->
    <div class="fw-semibold fs-6 text-gray-500 mb-7">
        No Permission
    </div>
    <!--end::Text-->

    <!--begin::Link-->
    <div class="mb-0">
        <a href="/admin" class="btn btn-sm btn-primary">Return Home</a>
    </div>
    <!--end::Link-->

</div>
<!--end::Card body-->
