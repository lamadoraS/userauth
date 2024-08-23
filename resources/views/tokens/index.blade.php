@extends('dashboard')
@section('table')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Authentication Tokens</h2>
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
                        <th>User</th>
                        <th>Token</th>
                        <th>Expiration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @php
                     $counter = ($tokens->currentPage() - 1) * $tokens->perPage();
                @endphp
                @foreach($tokens as $token)
                
                <tr>
                    <td>{{ $loop->iteration + $counter }}</td>
                    <td>{{ $token->user->first_name }}</td>
                    <td>{{ $token->token_value }}</td>
                    <td>{{ $token->expiration }}</td>
                    
                    <td>
                    <form id="delete-form-{{ $token->id }}" action="{{ route('tokens.destroy', $token->id) }}" method="POST">
                        <a class="btn btn-primary btn-sm" href="{{ route('tokens.edit', $token->id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <!-- Change the button type to "button" -->
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $token->id }})">Delete</button>
                </form>

                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div>{{ $tokens->links() }}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(tokenId) {
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
            document.getElementById('delete-form-' + tokenId).submit();
        }
    })
}
</script>
@endsection
