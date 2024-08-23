@extends('dashboard')
@section('table')
<script>
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
                document.getElementById('createUser').innerHTML = `<div class="pull-right mb-2">
                    <a class="btn btn-success" href="/userRole/${response.role_id}">Add User</a>
            </div> `;

            // document.getElementById('editUser').innerHTML = ` <a class="btn btn-primary btn-sm" href="/userRoleEdit/${response.role_id}">Edit</a>`
            }
          
        })
    });

</script>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users</h2>
            </div>

            <div id="createUser">

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
                    @php
                         $counter = ($user->currentPage() - 1) * $user->perPage();
                    @endphp
                    @foreach($user as $users)
                   
                    <tr>
                        <td>{{ $loop->iteration + $counter}}</td>
                        <td>
                          <center><img src="{{$users->image ? asset('storage/' . $users->image) : asset('assets/img/icon.jpg')}}" alt="Profile" height="50" width="50px" style="border-radius:50%;"></center>  
                         </td>
                        <td>{{ $users->first_name }}</td>
                        <td>{{ $users->last_name }}</td>
                        <td>{{ $users->email }}</td>
                        <td>{{ $users->phone_number }}</td>
                        <td> {{$users->roles->role_name}}</td>
                        <td>
                        <form id="delete-form-{{ $users->id }}" action="{{ route('users.destroy', $users->id) }}" method="POST">
                          <div id="editUser" ></div>
                          <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $users->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')
                            <!-- Change the button type to "button" -->
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $users->id }})">Delete</button>
                        <a class="btn btn-info btn-sm" href="{{ route('users.show', $users->id) }}">View</a>

                    </form>

                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{$user->links()}}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
            document.getElementById('delete-form-' + userId).submit();
        }
    })
}
</script>
@endsection
