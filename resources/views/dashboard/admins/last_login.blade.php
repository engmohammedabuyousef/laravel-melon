<div class="badge badge-light fw-bold">
    {{ $admin->last_login_at ? $admin->last_login_at->diffForHumans() : '-' }}
</div>
