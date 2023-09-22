<div class="badge badge-light fw-bold">
    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}
</div>
