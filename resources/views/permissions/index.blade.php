@extends('dashboard')
@section('table')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Permissions</h2>
            </div>
            
            <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('permissions.create') }}">Add Permissions</a>
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
                        <th>Permissions Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <tbody>
                    @php
                         $counter = ($permission->currentPage() - 1) * $permission->perPage();
                    @endphp
                    @foreach($permission as $permissions)
                   
                    <tr>
                        <td>{{ $loop->iteration + $counter}}</td>
                        <td>{{ $permissions->permission_name }}</td>
                         
                        <td>
                        <form id="delete-form-{{ $permissions->id }}" action="{{ route('permissions.destroy', $permissions->id) }}" method="POST">
                            <a class="btn btn-primary btn-sm" href="{{ route('permissions.edit', $permissions->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <!-- Change the button type to "button" -->
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $permissions->id }})">Delete</button>
                    </form>

                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{$permission->links()}}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(permissionId) {
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
            document.getElementById('delete-form-' + permissionId).submit();
        }
    })
}
</script>
@endsection
