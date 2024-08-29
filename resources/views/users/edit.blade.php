@extends('dashboard')
@section('table')

<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit User</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('users.index') }}" enctype="multipart/form-data"> Back</a>
                </div>
            </div>
        </div>

        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Profile Picture:</strong>
                            <input type="file" name="image" value="{{ $user->image }}" class="form-control" placeholder="Edit Profile Picture">
                            @error('Image')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            <div class="container-border">
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>First Name:</strong>
                            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" placeholder="Edit First Name">
                            @error('First Name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Last Name:</strong>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" placeholder="Edit Last Name">
                            @error('last_name')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email Address:</strong>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Edit Email Address">
                            @error('email')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone Number:</strong>
                            <input type="number" name="phone_number" value="{{ $user->phone_number }}" class="form-control" placeholder="Edit Phone Number">
                            @error('Phone Number')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                               <label for="role_id">Role</label>
                                <select name="role_id" class="form-control" id="role_id">
                                    @foreach ($roles as $role )
                                    <option value="{{$role->id}}">{{$user->role_id == $role->id ? 'selected' : ''}}
                                        {{$role->role_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Password:</strong>
                            <input type="password" name="password" value="{{ $user->password }}" class="form-control" placeholder="Edit Password">
                            @error('password')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endsection