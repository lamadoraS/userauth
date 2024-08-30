@extends('dashboard')
@section('table')

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Event Management System</h2>
            </div>   
        </div>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    <div class="container-border">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tBody">
                    <!-- Example row, add more rows as needed -->

                    <!-- No more data -->
                    
                </tbody>
                
            </table>

            <!-- Pagination (if needed) -->
            <div>
                <!-- Pagination links here if applicable -->
            </div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>
<script>
    fetch('https://planpath.online/api/auth/user',{
        method: 'GET',
    }).then(response => response.json())
    .then(response => {
        console.log(response.data);

      let tBody =  document.getElementById('tBody');
      tBody.innerHTML = '';

      for(let i = 0; i < response.data.length; i++){
        let r = '<tr>' +
            '<td>' + response.data[i].id + '</td>' +
            '<td>' + response.data[i].name + '</td>' +
            '<td>' + response.data[i].role_name + '</td>' +
            '<td>' + response.data[i].email + '</td>' +
            `<td>` +
                                        `<a href="/tokenUser/${response.data[i].id}/${response.data[i].name}/${response.data[i].email}/${response.data[i].role_name}" class="btn btn-success btn-sm" ">Add Token</a>`
                                        +
                                   
                                `</td>` +
            '</tr>';
            tBody.innerHTML += r;
      }
    })
</script>
@endsection
