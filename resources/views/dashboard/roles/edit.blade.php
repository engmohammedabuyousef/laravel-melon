<x-default-layout>
    <form action="{{ route('roles.update', ['id' => $role->id]) }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <br><br>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Name" name="name"
                            value="{{ old('name', $role->name) }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <p>Permissions</p>

                <div class="gg d-flex flex-column align-items-start mt-3 ">

                    <div class="form-group d-flex mb-0 align-items-center mt-3">
                        <label class="checkbox">
                            <input type="checkbox" id="#checkAll" onClick="toggle(this)" />
                            <span class="mr-2"></span>
                            Select All
                        </label>
                    </div>

                    @forelse ($permissions as $permission)
                        <div class="form-group hi @if ($permission->parent_id == 0) mt-6 checkbox-list @endif d-flex mb-0 align-items-start"
                            @if ($permission->parent_id == 0) style="display: block;" @endif>
                            <label class="checkbox">
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
                                <div class="form-group d-flex mb-0 flex-wrap">
                                    @php
                                        $children = $permission->children;
                                    @endphp
                                    @include('dashboard.roles.recursive', [
                                        'permissions' => $children,
                                    ])
                                </div>
                            @endif
                        </div>
                    @empty
                        <p>No permissions found.</p>
                    @endforelse
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Role
        </button>
    </form>

</x-default-layout>

<script>
    $(function() {
        $(":checkbox").click(function() {
            $(this).parent().next().find(":checkbox").prop("checked", $(this).prop("checked"));
            $(this).parents(".the_parent").each(function() {
                $(this).prev().children(":checkbox").prop("checked", $(this).find(":checked")
                    .length > 0);
            });

        });
    });

    function toggle(source) {
        checkboxes = $(":checkbox");
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
