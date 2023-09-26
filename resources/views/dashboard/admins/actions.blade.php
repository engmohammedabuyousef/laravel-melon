<div class="d-flex">
    <a href="/admin/admins/{{ $admin->id }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <i class="ki-duotone ki-switch fs-2">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
    </a>

    <a href="{{ route('admins.edit', ['id' => $admin->id]) }}"
        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
        <i class="ki-duotone ki-pencil fs-2">
            <span class="path1"></span>
            <span class="path2"></span></i>
    </a>

    <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
        <i class="ki-duotone ki-trash fs-2"><span class="path1"></span>
            <span class="path2"></span>
            <span class="path3"></span>
            <span class="path4"></span>
            <span class="path5"></span>
        </i>
    </a>

</div>
