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
                <h2>Audit Logs</h2>
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
                        <th>Role</th>
                        <th>Details</th>
                        <th>Timestamp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    use App\Models\AuditLog;
                    $auditlogs = AuditLog::with('user')->orderBy('created_at', 'desc')->simplePaginate(5); 
                    $counter = ($auditlogs->currentPage() - 1) * $auditlogs->perPage();
                    @endphp
                    @forelse($auditlogs as $log)
                        <tr>
                            <td>{{ $loop->iteration + $counter }}</td>
                            <td>{{ $log->user->roles->role_name ?? '' }}</td>
                            <td style="color: red;">{{ Str::limit($log->action, 50, '...') }}</td>
                            <td>{{ $log->created_at->format('m/d/Y h:i a') }}</td>
                            <td>
                                <form id="delete-form-{{ $log->id }}" action="{{ route('auditlogs.destroy', $log->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $log->id }})">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No Audit Logs Found</td>
                        </tr>
                   
                </tbody>
                 @endforelse
            </table>
            <div>{{ $auditlogs->links() }}</div>
        </div>
    </div>
    <br>
    <div class="pull-right back-button">
        <a class="btn btn-primary" href="{{ url('dashboard') }}">Back</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(logId) {
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
            document.getElementById('delete-form-' + logId).submit();
        }
    });
}
</script>
@endsection
