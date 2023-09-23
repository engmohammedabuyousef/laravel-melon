<x-default-layout>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <button type="submit" class="btn btn-primary">
            Add Role
        </button>
    </form>

</x-default-layout>
