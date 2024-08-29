@extends('dashboard')
@section('table')
<script>
    let roleId = localStorage.getItem('role_id');
    let currentUser = localStorage.getItem('user_id');

    if(roleId == 2){
        window.location.href = 'byRole/' + currentUser;
    }
</script>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Authentication Tokens</h2>
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
            <th>User</th>
            <th>Token</th>
            <th>Expiration</th>
            <th>Status</th> <!-- Added Status Column -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php
            $counter = ($tokens->currentPage() - 1) * $tokens->perPage();
        @endphp
        @forelse($tokens as $token)
            <tr>
                <td>{{ $loop->iteration + $counter }}</td>
                <td>{{ $token->user->first_name }}</td>
                <td>{{ Str::limit($token->token_value, 20, '...') }}</td>
                <td>{{ $token->expires_at }}</td>
                <td>
                    @if(now()->greaterThan($token->expires_at))
                        <span class="badge" style="background-color: #dc3545; color: white;">Expired</span> <!-- Red for Expired -->
                    @else
                        <span class="badge" style="background-color: #28a745; color: white;">Active</span> <!-- Green for Active -->
                    @endif
                </td>

                <td>
                    <form id="delete-form-{{ $token->id }}" action="{{ route('tokens.destroy', $token->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $token->id }})">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No Tokens Found</td>
            </tr>
        @endforelse
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
