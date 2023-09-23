<x-default-layout>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Title</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Title" name="title"
                            value="{{ old('title') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Body</label>
                    <div class="input-group">
                        <textarea class="form-control title" placeholder="Body" name="body" rows="5">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div>
            <label for="userType">Group User or Group:</label>
            <br>
            <select id="userType" name="userType">
                <option value="">Select an option</option>
                <option value="group">Group</option>
                <option value="user">Specific User</option>
            </select>
        </div>

        <div id="groupSelect" style="display: none;">
            <label for="group">Select a Group:</label>
            <select id="group" name="group">
                <option value="group1">Group 1</option>
                <option value="group2">Group 2</option>
                <!-- Add more group options as needed -->
            </select>
        </div>

        <div id="userSelect" style="display: none;">
            <label for="user">Select a User:</label>
            <select id="user" name="user">
                <option value="user1">User 1</option>
                <option value="user2">User 2</option>
                <!-- Add more user options as needed -->
            </select>
        </div>


        <script>
            const userTypeSelect = document.getElementById("userType");
            const groupSelect = document.getElementById("groupSelect");
            const userSelect = document.getElementById("userSelect");

            userTypeSelect.addEventListener("change", function() {
                if (userTypeSelect.value === "group") {
                    groupSelect.style.display = "block";
                    userSelect.style.display = "none";
                } else if (userTypeSelect.value === "user") {
                    groupSelect.style.display = "none";
                    userSelect.style.display = "block";
                }
            });
        </script>

        <div>
            {{-- Group or Specific User --}}
            {{-- select --}}
        </div>

        <div>
            {{-- choose the user or choose the group  --}}
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Add User
        </button>
    </form>

</x-default-layout>
