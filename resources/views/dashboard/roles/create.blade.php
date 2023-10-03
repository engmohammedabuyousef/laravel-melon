<x-default-layout>
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Name" name="name"
                            value="{{ old('name') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <button type="submit" class="btn btn-primary">
            Add Role
        </button>
    </form>

</x-default-layout>
