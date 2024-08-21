<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Login</title>
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
    <script>
       const token = localStorage.getItem('accessToken');
       
       if (token) {
           window.location.href = '/dashboard';
       }
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

        
        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <h3>Verify OTP</h3>
                            </div>
                        </div>

                        <!-- Your login form here -->

                        <!-- OTP Modal Trigger (Optional) -->
                        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#otpModal">
                            Open OTP Modal
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->

        <!-- OTP Modal Start -->
        <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="otpModalLabel">Enter OTP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/verifyCode" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="otp_code" class="form-label">OTP:</label>
                                <input type="text" name="otp_code" class="form-control @error('otp_code') is-invalid @enderror" id="otp_code" placeholder="Enter OTP" required>
                               
                            </div>
                            <button type="submit" class="btn btn-success w-100">Verify OTP</button>
                            <div id="otpmessage"></div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- OTP Modal End -->

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/lib/chart/chart.min.js"></script>
        <script src="assets/lib/easing/easing.min.js"></script>
        <script src="assets/lib/waypoints/waypoints.min.js"></script>
        <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="assets/lib/tempusdominus/js/moment.min.js"></script>
        <script src="assets/lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="assets/js/main.js"></script>

        <script>
            // Automatically show the modal on page load (optional)
            $(document).ready(function() {
                new bootstrap.Modal(document.getElementById('otpModal')).show();
            });

            // Function to start a countdown timer (optional)
            function startTimer(duration) {
                let timer = duration, minutes, seconds;
                setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    $('#otpmessage').text("Time left: " + minutes + ":" + seconds);

                    if (--timer < 0) {
                        timer = duration;
                    }
                }, 1000);
            }
            
            // Start timer (optional)
            startTimer(60);
        </script>
    </div>
</body>
</html>
