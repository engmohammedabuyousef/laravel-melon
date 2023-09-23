<x-default-layout>
    <form action="{{ route('notifications.store') }}" method="POST">
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

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="type">Group or Specific User</label>
                    <br>
                    <select id="type" name="type" class="form-select form-select-solid form-select-sm"
                        data-control="select2" data-hide-search="true">
                        <option value="">Select an option</option>
                        <option value="group">Group</option>
                        <option value="user">Specific User</option>
                    </select>
                </div>
            </div>
        </div>

        <br>

        <div id="groupSelect" style="display: none;">
            <div class="form-group">
                <label for="group">Choose a Group</label>
                <select id="group" name="group" class="form-select form-select-solid form-select-sm"
                    data-control="select2" data-hide-search="true">
                    <option value="">Select a group</option>
                    <option value="admins">Admins</option>
                    <option value="users">Users</option>
                    <option value="all">All</option>
                </select>
            </div>
        </div>

        <div id="userSelect" style="display: none;">
            <div class="form-group">
                <label for="user">Choose a Specific User</label>
                <select id="user" name="user" class="form-select form-select-solid form-select-sm"
                    data-control="select2" data-hide-search="false">
                    <option value="">Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#type').change(function() {
                    var selectedType = $(this).val();
                    if (selectedType === 'group') {
                        $('#groupSelect').show();
                        $('#userSelect').hide();
                    } else if (selectedType === 'user') {
                        $('#userSelect').show();
                        $('#groupSelect').hide();
                    } else {
                        $('#groupSelect').hide();
                        $('#userSelect').hide();
                    }
                });
            });
        </script>

        <br>

        <button type="submit" class="btn btn-primary">
            Send Notification
        </button>
    </form>

</x-default-layout>
