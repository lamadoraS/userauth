@extends('dashboard')
@section('table')
<script>
    let roleId = localStorage.getItem('role_id');
    let currentUser = localStorage.getItem('user_id');

    if(roleId == 2){
        window.location.href = 'byRole/' + currentUser;
    }
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/user', {
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
                accept: 'application/json',
            }
        }).then(response => response.json())
        .then(response => {
            console.log(response);
            if (response) {
                document.getElementById('createPermission').innerHTML = `
                    <div class="pull-right mb-2">
                        <a class="btn btn-success" href="/createPermissions/${response.role_id}">Add Permissions</a>
                    </div>`;
            }
        });
    });

    function editPermissions(id) {
        let editPermission = localStorage.setItem('editPermissionId', id);
        let thisRoleId = localStorage.getItem('role_id');
        window.location.href = '/editPermissions/' + thisRoleId + '/' + id;
    }

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
                deletePermissions(permissionId);
            }
        });
    }

    function deletePermissions(permissionId) {
        localStorage.setItem('deletePermissionId', permissionId);
        let thisRoleId = localStorage.getItem('role_id');
        if (thisRoleId) {
            window.location.href = '/deletePermissions/' + thisRoleId + '/' + permissionId;
        } else {
            console.error('Role ID not found in localStorage.');
        }
    }
</script>

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Permissions</h2>
            </div>
            <div id="createPermission"></div>
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
                        <th>Permission Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $counter = ($permission->currentPage() - 1) * $permission->perPage();
                    @endphp
                    @foreach($permission as $permissions)
                        <tr>
                            <td>{{ $loop->iteration + $counter }}</td>
                            <td>{{ $permissions->permission_name }}</td>
                            <td>
                                <form id="delete-form-{{ $permissions->id }}" action="{{ route('permissions.destroy', $permissions->id) }}" method="POST">
                                    <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="editPermissions({{ $permissions->id }})">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $permissions->id }})">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{ $permission->links() }}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
