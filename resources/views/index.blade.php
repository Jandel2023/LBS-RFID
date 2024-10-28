<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <title>Library Monitoring System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        div {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            color: red;
            animation: blink 1s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });

        var channel = pusher.subscribe('rfid-channel');

        channel.bind('rfid-channel', function(data) {

            if (data.status == 200) {
                document.getElementById('main-form').style.display = 'none';
                document.getElementById('borrow-form').style.display = 'block';
                
            } else {
                document.getElementById('main-form').style.display = 'block';
                document.getElementById('borrow-form').style.display = 'none';
                alert("The Card is not recognized in the system!");
            }
        });

        channel.bind('pusher:subscription_error', function(status) {
            console.error('Subscription error:', status);
        });
    </script>

</head>

<body>
    <div id="main-form" style="display: block">
        <h1>Library Monitoring System</h1>
        <p>Please tap your RFID Card!</p>
    </div>
    <div id="borrow-form" style="display: none;">
        <form action="" method="POST">
            @csrf
            <input type="text" name="name" placeholder="Name" />
            <button type="submit">Submit</button>
        </form>
    </div>

</body>

</html> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Plumberz - Free Plumbing Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="welcome_theme/welcome_theme/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="welcome_theme/lib/animate/animate.min.css" rel="stylesheet">
    <link href="welcome_theme/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="welcome_theme/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="welcome_theme/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="welcome_theme/css/style.css" rel="stylesheet">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });

        var channel = pusher.subscribe('rfid-channel');

        channel.bind('rfid-channel', function(data) {

            if (data.status == 200) {
                console.log(data.user);
                const videoModal = new bootstrap.Modal(document.getElementById('profileModalLabel'));
                const image =  '/storage/' + data.user.profile_img;
                videoModal.show();

                document.getElementById('full_name').innerHTML = data.user.full_name;
                document.getElementById('rfid').innerHTML = data.user.rfid;
                document.getElementById('email').innerHTML = data.user.email;
                
                //input hidden value
                document.getElementById('profileID').value = data.user.id;

                if(data.user.profile_img == null){
                    // document.getElementById('profilePicture').src = '/storage/' + data.user.profile_img;
                    document.getElementById('profilePicture').src = 'storage/profile_default.png';

                }else{
                    // document.getElementById('profilePicture').src = public_path('/welcome_theme/img/profile_default');
                    document.getElementById('profilePicture').src = image;
                }

                // document.getElementById('profileForm').innerHTML = `action=`{data.user.id}`;
                
            } else {
                // alert("The Card is not recognized in the system!");
                    Swal.fire({
                    icon: 'error',
                    title: "User Not Found!",
                    showCancelButton: true,
                    denyButtonText: `Closed`
                    }).then((result) => {

            if (result.isDenied) {
                     window.location.reload();
                    }
                    })
                        }
        });

        channel.bind('pusher:subscription_error', function(status) {
            console.error('Subscription error:', status);
        });
    </script>
</head>

<body>

<!-- Modal For Borrow -->
 <div  class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-0">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">RFID-SYTEM</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- 16:9 aspect ratio -->
                           
                        </div>
                    </div>
                </div>
</div>

<!-- Sample -->

<!-- Profile Modal -->
 @include('borrow')
 @include('register')
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-light d-none d-lg-block">
        <div class="row align-items-center top-bar">
            <div class="col-lg-3 col-md-12 text-center text-lg-start">
                <a href="" class="navbar-brand m-0 p-0">
                    <h1 class="text-primary m-0">RFID_SYSTEM</h1>
                </a>
            </div>
            <div class="col-lg-9 col-md-12 text-end">
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <i class="fa fa-map-marker-alt text-primary me-2"></i>
                    <p class="m-0">MLGCL College of Learning INC.</p>
                </div>
                <div class="h-100 d-inline-flex align-items-center me-4">
                    <i class="far fa-envelope-open text-primary me-2"></i>
                    <p class="m-0">mlgcl.edu.ph</p>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-sm-square bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid nav-bar bg-light">
        <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
            <a href="" class="navbar-brand d-flex align-items-center m-0 p-0 d-lg-none">
                <h1 class="text-primary m-0">Plumberz</h1>
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav me-auto">
                    <a href="" class="nav-item nav-link active">Home</a>
              @if (auth()->user())  
              <a href="{{route('login')}}" class="nav-item nav-link">Dashboard</a>
              @else
              <a href="{{route('login')}}" class="nav-item nav-link">Login</a>
              @endif
             
            </div>
        </nav>
    </div>

        <div class="container-xxl">
        <div class="container">
            <div class="row g-5">
                <!-- About Section -->
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase">RFID</h6>
                    <h1 class="mb-4">RFID SYSTEM USING ARDUINO</h1>
                    <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat amet</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Residential & commercial plumbing</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Quality services at affordable prices</p>
                    <p class="fw-medium text-primary"><i class="fa fa-check text-success me-3"></i>Immediate 24/ 7 emergency services</p>
                </div>

                <!-- Fact Section -->
                <div class="col-lg-6">
        <div class="container-fluid fact bg-dark my-5 py-5">
            <div class="container" style="max-width: 1000px;"> <!-- Set a max-width for the container -->
                <div class="row g-4 justify-content-center"> <!-- Added justify-content-center to center the elements -->
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                        <i class="fa fa-check fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                        <p class="text-white mb-0">Borrowers</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                        <i class="fa fa-users-cog fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                        <p class="text-white mb-0">Users</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-users fa-2x text-white mb-3"></i>
                        <h2 class="text-white mb-2" data-toggle="counter-up">1234</h2>
                        <p class="text-white mb-0">Profiles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- End of Fact Section -->
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Address</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Opening Hours</h4>
                        <h6 class="text-light">Monday - Friday:</h6>
                        <p class="mb-4">09.00 AM - 09.00 PM</p>
                        <h6 class="text-light">Saturday - Sunday:</h6>
                        <p class="mb-0">09.00 AM - 12.00 PM</p>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Services</h4>
                        <a class="btn btn-link" href="">Drain Cleaning</a>
                        <a class="btn btn-link" href="">Sewer Line</a>
                        <a class="btn btn-link" href="">Water Heating</a>
                        <a class="btn btn-link" href="">Toilet Cleaning</a>
                        <a class="btn btn-link" href="">Broken Pipe</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Newsletter</h4>
                        <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="welcome_theme/lib/wow/wow.min.js"></script>
    <script src="welcome_theme/lib/easing/easing.min.js"></script>
    <script src="welcome_theme/lib/waypoints/waypoints.min.js"></script>
    <script src="welcome_theme/lib/counterup/counterup.min.js"></script>
    <script src="welcome_theme/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="welcome_theme/lib/tempusdominus/js/moment.min.js"></script>
    <script src="welcome_theme/lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="welcome_theme/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Javascript -->
    <script src="welcome_theme/js/main.js"></script>
</body>

</html>
