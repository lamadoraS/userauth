@extends('dashboard')
@section('table')

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Users</p>
                    <h6 class="mb-0">{{$totalUser}}</h6> <!-- Display the total users count -->
                    
                </div>
            </div>
        </div>
        
        <!-- Total Consumer -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-shopping-cart fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Consumer</p>
                    <h6 class="mb-0">{{$totalCustomer}}</h6> <!-- Display the total API consumers count -->
                </div>
            </div>
        </div>
        
        <!-- Total Guest -->
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-user fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Guest</p>
                    <h6 class="mb-0">{{$totalGuest}}</h6> <!-- Display the total guests count -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
