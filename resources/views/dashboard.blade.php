 <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.icon" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href='{{asset("assets/lib/owlcarousel/assets/owl.carousel.min.css")}}' rel="stylesheet">
    <link href='{{asset("assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css")}}' rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href='{{asset("assets/css/bootstrap.min.css")}}' rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href='{{asset("assets/css/style.css")}}' rel="stylesheet">
    
    <script>
     
   const token = localStorage.getItem('token');
   if (!token) {
       window.location.href = '/';
   }

   document.addEventListener('DOMContentLoaded', function(){
        fetch('/api/user', {
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + token,
                application: 'application/json',
            }
        }).then(response => {
            
            return response.json();
        })
        .then(response => {
            if(response){
                if(response.token === null){
                    localStorage.removeItem('token');
                    localStorage.removeItem('role_id');
                    localStorage.removeItem('user_id');
                    
                    swal({
                        title: "Token Expired",
                        text: "Your token has expired, please wait for the activation email and login again to activate your account.",
                        icon: "warning",
                        button: "OK",
                    }).then(() => {
                        window.location.href = '/login';
                    });
                    }

                document.getElementById('FirstName').innerHTML = response.first_name;
                document.getElementById('firstName').innerHTML = response.first_name;

                if(response.image){
                    document.getElementById('Image').src = ('storage/' + response.image);
                    document.getElementById('image').src = ('storage/' + response.image);
                } else {
                    document.getElementById('Image').src = `{{asset('assets/img/icon.jpg')}}`;
                    document.getElementById('image').src = `{{asset('assets/img/icon.jpg')}}`;
                }

                if(response.role_id == 1){
                    document.getElementById('Role').innerHTML = 'Admin';
                } else if(response.role_id == 2) {
                    document.getElementById('Role').innerHTML = 'User';
                } else if(response.role_id == 3) {
                    document.getElementById('Role').innerHTML = 'Api Consumer';
                } else if(response.role_id == 4) {
                    document.getElementById('Role').innerHTML = 'Guest';
                }

                if (response.role_id !== 1) {
                    document.getElementById('notificationDropdown').style.display = 'none';
                }

                if(response.role_id == 1){
                    document.getElementById('navigationBar').innerHTML = `  
                        <div class="navbar-nav w-100">
                            <a href="{{ url('/index') }}" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                            <a href="{{ route('users.index') }}" class="nav-item nav-link"><i class="fa fa-user me-2"></i>User</a>
                            <a href="{{ route('roles.index') }}" class="nav-item nav-link"><i class="fa fa-key me-2"></i>Roles</a>
                            <a href="{{ route('permissions.index') }}" class="nav-item nav-link"><i class="fa fa-lock me-2"></i>Permissions</a>
                            <a href="{{ route('tokens.index') }}" class="nav-item nav-link"><i class="fa fa-shield-alt me-2"></i>Tokens</a>
                            <a href="{{ route('auditlogs.index') }}" class="nav-item nav-link"><i class="fa fa-file-alt me-2"></i>Logs</a>
                        </div>
                    `;
                }

                if(response.role_id == 4){
                    document.getElementById('routeUser').innerHTML = `<a href="/guestRole/${response.id}" class="nav-item nav-link"><i class="fa fa-user me-2"></i>User</a>`;
                }

                if(response.role_id == 2){
                    document.getElementById('routeUser').innerHTML = `<a href="/byRole/${response.id}" class="nav-item nav-link"><i class="fa fa-user me-2"></i>User</a>`;
                }
            }
        });
   });

  
</script>

  
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="{{ url('/dashboard') }}" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i ></i>Centralized</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img id="Image" class="rounded-circle" src=""  alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0" id="FirstName" ></h6>
                        <span id="Role"></span>
                    </div>
                </div>
                 <div id="navigationBar"></div>
                <div class="navbar-nav w-100">
                   
                    <div id="routeUser" ></div>
                </div>
                </div>
             
              

            </nav>
        </div>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="{{ url('/dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
            
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">

                    </div>
                    @php
                    use App\Models\AuditLog;
                    $auditlogs = AuditLog::get();
                     @endphp
                    <div class="nav-item dropdown" id="notificationDropdown">
                        <a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#notifModal">
                            <i class="fa fa-bell me-lg-2 position-relative">
                                <!-- Badge for notification count -->
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{count($auditlogs)}}<!-- Replace with the actual notification count -->
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </i>
                            <span class="d-none d-lg-inline-flex" >Notifications</span>
                        </a>
                    </div>
                

             <div class="nav-item dropdown">
                <a href="#" id="userDropdown" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img id="image" class="rounded-circle me-lg-2" src='' alt="" style="width: 40px; height: 40px;">
                <span id="firstName" class="d-none d-lg-inline-flex"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item" onclick="confirmLogout()">Log Out</a>
                </div>
            </div>

                </div>
            </nav>
            <!-- Navbar End -->


             @yield('table')
             @include('notification-modal')
        </div>
        <!-- Content End -->

  
        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src={{asset("assets/lib/chart/chart.min.js")}}></script>
    <script src={{asset("assets/lib/easing/easing.min.js")}}></script>
    <script src={{asset("assets/lib/waypoints/waypoints.min.js")}}></script>
    <script src={{asset("assets/lib/owlcarousel/owl.carousel.min.js")}}></script>
    <script src={{asset("assets/lib/tempusdominus/js/moment.min.js")}}></script>
    <script src={{asset("assets/lib/tempusdominus/js/moment-timezone.min.js")}}></script>
    <script src={{asset("assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js" )}}></script>

    <!-- Template Javascript -->
    <script src={{asset("assets/js/main.js")}}></script>
    <script src='{{asset("assets/js/sweetalert.min.js")}}'></script>
    <script>
    function confirmLogout() {
        swal({
            text: "Are you sure you want to logout?",
            buttons: ["Cancel", "Logout"],
        }).then((value) => {
            if (value) {
                localStorage.removeItem('accessToken');
                localStorage.removeItem('token');
                localStorage.removeItem('editUserId');
                localStorage.removeItem('editRoleId');
                localStorage.removeItem('deleteUserId');
                localStorage.removeItem('deleteRoleId');
                localStorage.removeItem('deletePermissionId');
                localStorage.removeItem('editPermissionId');
                localStorage.removeItem('ShowUserId');
                localStorage.removeItem('role_id');
                localStorage.removeItem('user_id');
                window.location.href = '/';
            }
        });
    }
</script>

</body>

</html>