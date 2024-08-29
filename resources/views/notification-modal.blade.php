
<script>
    
</script>
<div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notifModalLabel">Notifications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @php
                            use App\Models\AuditLog;
                            $auditlogs = AuditLog::orderBy('created_at', 'desc')->get();
                            @endphp
                            @foreach($auditlogs as $log)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-normal mb-0">{{ $log->action }}</h6>
                                <small style="color: red;">
                                    {{ $log->created_at->diffForHumans() }}
                                    ({{ $log->created_at->format('m/d/Y h:i a') }})
                                    </small>
                            </div>
                            <!-- Optional: Add actions like delete or view more details here -->
                            </div>
                            <hr class="my-2">
                            @endforeach
                            <a href="{{ route('auditlogs.index') }}" class="d-block text-center text-decoration-none">See all notifications</a>
                        </div>
                        </div>
                    </div>
                </div>