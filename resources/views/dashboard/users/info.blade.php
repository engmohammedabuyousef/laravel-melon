<div class="d-flex align-items-center">
    <!--begin::Avatar-->
    <div class="symbol symbol-45px me-5">
        @if ($user->photo)
            <img alt="Pic" src="{{ $user->photo }}">
        @else
            <span class="symbol-label bg-light-danger text-danger fw-bold">
                {{ substr($user->name, 0, 1) }}
            </span>
        @endif
    </div>
    <!--end::Avatar-->

    <!--begin::Name-->
    <div class="d-flex justify-content-start flex-column">
        <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">{{ $user->name }}</a>

        <a href="#" class="text-muted text-hover-primary fw-semibold text-muted d-block fs-7">
            {{ $user->email }}
        </a>
    </div>
    <!--end::Name-->
</div>
