@extends('dashboard')
@section('table')

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Permissions</h2>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    <div class="container-border">
        <div class="table-responsive">
            <form action="{{ route('permissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container-border">
                    <div class="row">
                        <!-- Permission Name Input -->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permissions Name:</strong>
                            <select name="permission_name" class="form-control">
                                <option value="">Select Permission</option>
                                <option value="create_user">Create User</option>
                                <option value="delete_user">Delete User</option>
                                <option value="update_user">Update User</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>

                        <!-- Checkboxes -->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Roles:</strong><br>
                                @foreach ($roles as  $role)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="role_id[]" id="read" value="{{$role->id}}">
                                    <label class="form-check-label" for="read">{{$role->role_name}}</label>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary ml-3">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{route('permissions.index') }}">Back</a>
    </div>
</div>
@endsection
