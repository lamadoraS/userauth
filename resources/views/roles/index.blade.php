@extends('dashboard')
@section('table')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Roles</h2>
            </div>
            
            <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('roles.create') }}">Add Roles</a>
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
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                    @php
                         $counter = ($role->currentPage() - 1) * $role->perPage();
                    @endphp
                    @foreach($role as $roles)
                   
                    <tr>
                        <td>{{ $loop->iteration + $counter}}</td>
                        <td>{{ $roles->role_name }}</td>
                        <td>
                        <form id="delete-form-{{ $roles->id }}" action="{{ route('roles.destroy', $roles->id) }}" method="POST">
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $roles->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <!-- Change the button type to "button" -->
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $roles->id }})">Delete</button>
                    </form>

                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{$role->links()}}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(roleId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + roleId).submit();
        }
    })
}
</script>
@endsection
