<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="assets/js/sweetalert.min.js"></script>
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


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h3>Sign Up</h3>
                            </div>
                        </div>
                        <form id="signUpForm" method="post">
                        
                            <div class="form-floating mb-3">
                                <input type="text" name="first_name" class="form-control" id="floatingText1" placeholder="First Name">
                                <label for="floatingText">First Name:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="last_name" class="form-control" id="floatingText" placeholder="Last Name">
                                <label for="floatingText">Last Name:</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" name="phone_number" class="form-control" id="floatingInput" placeholder="Phone Number">
                                <label for="floatingInput">Phone Number</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="file" name="image" class="form-control" id="floatingInput" placeholder="Profile Picture">
                                <label for="floatingInput">Profile Picture</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                                <label for="floatingPassword">Password</label>
                                <input type ="hidden" name="role" class="form-control" value="guest">
                            </div>
                            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">Already have an Account? <a href="{{ url('/dashboard') }}">Sign In</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->    

        <script>
    document.getElementById('signUpForm').addEventListener('submit', function(event) {
        event.preventDefault(); 
        const formData = new FormData(this);

        fetch('/api/auth/register', {
            method: 'POST',
            body: formData,
            headers: {
                Accept: 'application/json',
            }
        }).then(response => {
            return response.json();
        }).then(data => {
            if(data.status && data.message === "User Created Successfully"){
                swal({
                    title: "Success!",
                    text: "User created successfully. You will be redirected to the login page to log in with your credentials.",
                    icon: "success",
                    button: "Ok"
                }).then(() => {
                    window.location.href = '/login'; 
                });
            } else {
                swal({
                    title: "Error!",
                    text: data.message || "An error occurred while creating the user.",
                    icon: "error",
                    button: "Try Again"
                });
            }
        
        });
    });
</script>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/chart/chart.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
    <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>

</html>