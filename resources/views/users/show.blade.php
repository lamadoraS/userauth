@extends('dashboard')

@section('table')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="font-weight-bold">User Profile</h4>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/img/icon.jpg') }}" alt="Profile" class="rounded-circle" height="140" width="140">
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-4 text-right font-weight-bold">First Name:</label>
                        <div class="col-sm-8">{{ $user->first_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 text-right font-weight-bold">Last Name:</label>
                        <div class="col-sm-8">{{ $user->last_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 text-right font-weight-bold">Email:</label>
                        <div class="col-sm-8">{{ $user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 text-right font-weight-bold">Phone Number:</label>
                        <div class="col-sm-8">{{ $user->phone_number }}</div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-4 text-right font-weight-bold">Role:</label>
                        <div class="col-sm-8">{{ $user->roles->role_name }}</div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
