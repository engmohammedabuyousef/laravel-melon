<x-default-layout>
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <!--begin::Card header-->
            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <label>Photo</label>
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body text-center pt-0">
                <!--begin::Image input-->
                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                    style="background-image: url('{{ asset('assets/images/default_user.png') }}');"
                    data-kt-image-input="true">
                    <!--begin::Preview existing avatar-->
                    <div class="image-input-wrapper w-150px h-150px"></div>
                    <!--end::Preview existing avatar-->

                    <!--begin::Label-->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change avatar"
                        data-bs-original-title="Change avatar" data-kt-initialized="1">
                        <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                                class="path2"></span></i>
                        <!--begin::Inputs-->
                        <input type="file" name="photo" accept=".png, .jpg, .jpeg, .jfif">
                        <input type="hidden" name="avatar_remove">
                        <!--end::Inputs-->
                    </label>
                    <!--end::Label-->

                    <!--begin::Cancel-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel avatar"
                        data-bs-original-title="Cancel avatar" data-kt-initialized="1">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                    <!--end::Cancel-->

                    <!--begin::Remove-->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                        data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove avatar"
                        data-bs-original-title="Remove avatar" data-kt-initialized="1">
                        <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span class="path2"></span></i>
                    </span>
                    <!--end::Remove-->
                </div>
                <!--end::Image input-->

                <!--begin::Description-->
                <div class="text-muted fs-7">
                    Only *.png, *.jpg, *.jpeg and *.jfif image files are accepted
                </div>
                <!--end::Description-->
            </div>
            <!--end::Card body-->
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Name" name="name"
                            value="{{ old('name') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Email" name="email"
                            value="{{ old('email') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Phone Number" name="phone_number"
                            value="{{ old('phone_number') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control title" placeholder="Password" name="password">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Password Confirmation</label>
                    <div class="input-group">
                        <input type="password" class="form-control title" placeholder="Password Confirmation"
                            name="password_confirmation">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Add User
        </button>
    </form>

</x-default-layout>
