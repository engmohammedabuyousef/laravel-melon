<!--begin:: Avatar -->
<div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
    @if ($user->photo)
        <div class="symbol-label">
            <img src="{{ $user->photo }}" class="w-100" />
        </div>
    @else
        <div
            class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name) }}">
            {{ substr($user->name, 0, 1) }}
        </div>
    @endif
</div>
<!--end::Avatar-->
<!--begin::User details-->
<div class="d-flex flex-column">
    {{ $user->name }}
    <span>{{ $user->email }}</span>
</div>
<!--begin::User details-->
