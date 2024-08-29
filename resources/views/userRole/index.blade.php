@extends('dashboard')

@section('table')
<script>
  
  let userID = localStorage.getItem('user_id');
  let UserRoleID = localStorage.getItem('role_id');
  if(UserRoleID != 2){
    window.location.href = '/dashboard';
  }else{
    let path = window.location.pathname.split('/').pop();
    if(userID != path){
    window.location.href = '/byRole/' + userID;
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
           
            let role = localStorage.setItem('role_id', response.role_id);
            
            if (response) {
                document.getElementById('createUser').innerHTML = `
                    <div class="pull-right mb-2">
                        <a class="btn btn-success" href="/userRole/${response.role_id}">Add User</a>
                    </div>`;
            }
        });
    });

    function showUser(userId) {
        let thisRoleId = localStorage.getItem('role_id');
        if (thisRoleId) {
            window.location.href = '/userRoleShow/' + thisRoleId + '/' + userId;
        } else {
            console.error('Role ID not found in localStorage.');
        }
    }

    function editUser(I) {
        let editUser = localStorage.setItem('editUserId', I);
        let thisRoleId = localStorage.getItem('role_id');

        window.location.href = '/userRoleEdit/' + thisRoleId + '/' + I;
    }

    function confirmDelete(userId) {
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
                deleteUser(userId); // Call deleteUser function with the userId
            }
        });
    }

    function deleteUser(userId) {
        // Store the userId in localStorage
        localStorage.setItem('deleteUserId', userId);

        // Retrieve the role_id from localStorage
        let thisRoleId = localStorage.getItem('role_id');

        // Ensure that role_id exists in localStorage
        if (thisRoleId) {
            // Redirect to the delete URL
            window.location.href = '/userRoleDelete/' + thisRoleId + '/' + userId;
        } else {
            console.error('Role ID not found in localStorage.');
        }
    }
  }
 
</script>

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users</h2>
            </div>
<div id="createUser"></div>
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
                   
                        <th>Profile Picture</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                         
                        <td>
                            <center>
                                <img src="{{ $users?->image ? asset('storage/' . $users?->image) : asset('assets/img/icon.jpg') }}" alt="Profile" height="50" width="50px" style="border-radius:50%;">
                            </center>
                        </td>
                        <td>{{ $users?->first_name }}</td>
                        <td>{{ $users?->last_name }}</td>
                        <td>{{ $users?->email }}</td>
                        <td>{{ $users?->phone_number }}</td>
                        <td>{{ $users?->roles->role_name }}</td>
                        <td>
                            <form id="delete-form-{{ $users->id ?? ''}}" action="{{ route('users.destroy', $users->id ?? 0) }}" method="POST">
                                <a class="btn btn-primary btn-sm" href="javascript:void(0);" onclick="editUser({{ $users?->id }})">Edit</a>
                                @csrf
                                @method('DELETE')
                                <!-- Change the button type to "button" -->
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $users?->id }})">Delete</button>
                                <a class="btn btn-info btn-sm" href="javascript:void(0);" onclick="showUser({{ $users?->id }})">View</a>
                            </form>
                        </td>
                    </tr>
               
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
