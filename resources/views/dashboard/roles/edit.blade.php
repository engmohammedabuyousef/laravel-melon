<x-default-layout>
    <form action="{{ route('roles.update', ['id' => $role->id]) }}" method="POST">
        @csrf

        <label for="name">Name:</label>

        <input type="text" name="name" id="name" required>

        <br>
        <br>
        <br>

        {{-- Permissions --}}

        Permissions

        <br>
        <br>
        <br>

        <button type="submit" class="btn btn-primary">
            Update Role
        </button>
    </form>


</x-default-layout>
