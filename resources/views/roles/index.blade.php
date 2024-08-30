@extends('dashboard')
@section('table')
<script>
    
    let roleId = localStorage.getItem('role_id');
    let currentUser = localStorage.getItem('user_id');

    if(roleId == 2){
        window.location.href = 'byRole/' + currentUser;
    }
    document.addEventListener('DOMContentLoaded', function(){
        fetch('/api/user', {
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token'),
                accept: 'application/json',
            }
        }).then(response => response.json())
        .then(response => {
            console.log(response);
            if(response){
                  document.getElementById('createRole').innerHTML = `<div class="pull-right mb-2">
                    <a class="btn btn-success" href="/createRole/${response.role_id}">Add Roles</a>
            </div> `;

            }
          
        })
    });
    function editRole(I){
    let editRole = localStorage.setItem('editRoleId', I);
    let thisRoleId =localStorage.getItem('role_id');

    window.location.href = '/editRole/' + thisRoleId + '/' + I;

    }
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
                deleteRole(roleId);
            }
        });
    }

    function deleteRole(roleId) {
        // Store the roleId in localStorage
        localStorage.setItem('deleteRoleId', roleId);

        // Retrieve the role_id from localStorage
        let thisRoleId = localStorage.getItem('role_id');

        // Ensure that role_id exists in localStorage
        if (thisRoleId) {
            // Redirect to the delete URL
            window.location.href = '/DeleteRole/' + thisRoleId + '/' + roleId;
        } else {
            console.error('Role ID not found in localStorage.');
        }
    }
    
</script>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Roles</h2>
            </div>
            <div id="createRole"></div>
            
            
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
                        <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="editRole({{ $roles->id }})">Edit</a>
                            
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
<!-- <script>
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
</script> -->
@endsection
