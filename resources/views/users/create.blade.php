@extends('dashboard')
@section('table')

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Users</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-border">
        <div class="table-responsive">
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Profile Picture:</strong>
                        <input type="file" name="image" class="form-control" placeholder="Enter Profile Picture">
                    </div>
                </div>
                <div class="container-border">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>First Name:</strong>
                            <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" value="{{ old('first_name') }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Last Name:</strong>
                            <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" value="{{ old('last_name') }}">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email Address:</strong>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email Address" value="{{ old('email') }}">
                            @error('email')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone Number:</strong>
                            <input type="number" name="phone_number" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select name="role_id" class="form-control" id="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                            <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
    </div>
</div>

@endsection
