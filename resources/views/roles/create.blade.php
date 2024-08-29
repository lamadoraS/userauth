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
                <h2>Add New Roles</h2>
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
        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Role Name:</strong>
                                <input type="text" name="role_name" class="form-control" placeholder="Enter Your Role Name">
                            </div>
                        </div>
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
        <a class="btn btn-primary" href="{{route('roles.index') }}">Back</a>
    </div>
</div>
@endsection