<div class="menu-item px-3">
    <a href="/admin/users/{{ $user->id }}" class="menu-link px-3">
        Show
    </a>
    <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="menu-link px-3">
        Edit
    </a>
    <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" data-kt-action="delete_row">
        Delete
    </a>
</div>
