<div class="menu-item px-3">
    <a href="/admin/admins/{{ $admin->id }}" class="menu-link px-3">
        Show
    </a>
    <a href="{{ route('admins.edit') }}" class="menu-link px-3" data-kt-user-id="{{ $admin->id }}">
        Edit
    </a>
    <a href="#" class="menu-link px-3" data-kt-admin-id="{{ $admin->id }}" data-kt-action="delete_row">
        Delete
    </a>
</div>
