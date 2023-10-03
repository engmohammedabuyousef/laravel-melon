@forelse ($permissions as $permission)
    <div class="form-group @if ($permission->parent_id == 0) mt-2 checkbox-list @endif mr-1 d-flex mb-0 align-items-center"
        @if ($permission->parent_id == 0) style="display: block;" @endif>
        <label class="checkbox mb-0 mb-2 mr-2">
            <input type="checkbox" name="permission[]" value="{{ $permission->name }}"
                @if (!empty($role) && in_array($permission->name, $rolePermissions)) checked @endif>
            <span class="mr-2"></span>
            @if ($permission->parent_id == 0)
                <strong>{{ ucfirst($permission->name) }}</strong>
            @else
                {{ ucfirst($permission->name) }}
            @endif
        </label>

        @if ($permission->children()->first())
            <div class="form-group d-flex mb-0">
                @php
                    $children = $permission->children;
                @endphp
                @include('dashboard.roles.recursive', ['permissions' => $children])
            </div>
        @endif
    </div>
@empty
    <p>No permissions found.</p>
@endforelse
