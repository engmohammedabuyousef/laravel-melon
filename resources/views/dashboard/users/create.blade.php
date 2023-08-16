<x-default-layout>
    <form action="{{ route('users.store') }}" method="POST">
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

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Email" name="email"
                            value="{{ old('email') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Phone Number</label>
                    <div class="input-group">
                        <input type="text" class="form-control title" placeholder="Phone Number" name="phone_number"
                            value="{{ old('phone_number') }}">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control title" placeholder="Password" name="password">
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Password Confirmation</label>
                    <div class="input-group">
                        <input type="password" class="form-control title" placeholder="Password Confirmation"
                            name="password_confirmation">
                    </div>
                </div>
            </div>
        </div>

        <br>


        <button type="submit" class="btn btn-primary">
            Add User
        </button>
    </form>

</x-default-layout>