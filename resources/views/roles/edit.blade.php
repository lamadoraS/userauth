@extends('dashboard')
@section('table')
<script>
      let roleId = localStorage.getItem('role_id');
            let currentUser = localStorage.getItem('user_id');

            if(roleId == 2){
                window.location.href = '/dashboard';
            }
</script>
<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Edit Roles</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('roles.index') }}" enctype="multipart/form-data"> Back</a>
                </div>
            </div>
        </div>

        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif

        <form action="{{ route('roles.update', $role->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="container-border">
                <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Role Name:</strong>
                            <input type="text" name="role_name" value="{{$role->role_name}}" class="form-control" placeholder="Edit Role Name">
                            @error('Role Name')
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