<x-default-layout>
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>

        <!-- Add more input fields for other user attributes as needed -->

        <button type="submit" class="btn btn-primary">
            {!! getIcon('plus', 'fs-2') !!}
            Add User
        </button>
    </form>

</x-default-layout>