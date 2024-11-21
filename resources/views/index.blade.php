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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f8ff;
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        /* Centered Container */
        .container {
            text-align: center;
        }

        /* Blinking Title */
        .title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2a9d8f;
            margin-bottom: 30px;
        }

        /* Loading Animation */
        .loading-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .loading-spinner {
            width: 35px;
            height: 35px;
            border: 4px solid #2a9d8f;
            border-top: 4px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            padding-top: 15px;
            font-size: 1.7rem;
            color: #264653;
            animation: blink 1.5s infinite;
        }

        /* Profile Card */
        .profile-container {
            display: none;
            width: 100%;
            max-width: 1000px;
            background-color: #ffffff;
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            margin: 70px;
        }

        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .profile-content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .profile-details {
            flex: 2;
            min-width: 200px;
        }

        .profile-image {
            width: 100%;
            max-width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #2a9d8f;
        }

        .profile-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2a9d8f;
            margin-bottom: 10px;
        }

        .profile-subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .profile-text {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #333333;
        }

        .label {
            font-weight: bold;
            color: #264653;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-borrow {
            background-color: #2a9d8f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-cancel {
            background-color: #e76f51;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px;
            }

            .profile-content {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .profile-details {
                text-align: center;
            }

            .profile-title {
                font-size: 1.8rem;
            }

            .profile-text {
                font-size: 1rem;
            }

            .btn-container {
                justify-content: center;
                gap: 10px;
            }
        }

        /* Blinking Animation */
        @keyframes blink {
            0%, 100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* Spinner Animation */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        });

        var channel = pusher.subscribe('rfid-channel');

        channel.bind('rfid-channel', function (data) {
            if (data.status == 200) {

                // console.log(data.user.id);
                document.getElementById('section1').style.display = 'none';
                document.getElementById('profile-container').style.display = 'block';

                document.getElementById('profile_id').value = data.user.id;
                document.getElementById('rfid').textContent = data.user.rfid;
                document.getElementById('full_name').textContent = data.user.full_name;
                document.getElementById('email').textContent = data.user.email;

                if (data.user.profile_img == null) {
                    document.getElementById('profilePicture').src = 'storage/profile_default.png';
                } else {
                    document.getElementById('profilePicture').src = data.user.profile_img;
                }
            }else{
                document.getElementById('section1').style.display = 'none';
                document.getElementById('profile-container').style.display = 'none';

              Swal.fire({
  icon: 'error',
  title: "User Not Found!",
  denyButtonText: 'Closed',
//   showDenyButton: true,
  timer: 5000, // Auto close after 5 seconds (5000ms)
  timerProgressBar: true
}).then((result) => {
  if (result || result.dismiss === Swal.DismissReason.timer) {
    window.location.reload();
  }
});


            }
        });

       
    </script>
</head>

<body>
    <div id="section1" class="container">
        <h1 class="title">Library System (RFID)</h1>
        <div class="loading-container">
            <div class="loading-spinner"></div>
            <p class="loading-text">Waiting for card...</p>
        </div>
    </div>

    <form id="borrowForm">
        <input type="hidden" id="profile_id" name="profile_id">
        <div id="profile-container" class="profile-container">
            <div class="profile-header">
                <h2 class="profile-title">User Profile</h2>
            </div>
            <div class="profile-content">
                <div class="profile-details">
                    <p class="profile-text"><span class="label">RFID:</span> <span id="rfid"></span></p>
                    <p class="profile-text"><span class="label">Name:</span> <span id="full_name"></span></p>
                    <p class="profile-text"><span class="label">Email:</span> <span id="email"></span></p>
                </div>
                <img id="profilePicture" alt="Profile Image" class="profile-image">
            </div>
            <div class="btn-container">
                <a class="btn btn-cancel"  href="/">Cancel</a>
                <button type="submit" class="btn btn-borrow" >Borrow</button>
            </div>
        </div>
    </form>
</body>
<script>
    document.getElementById('borrowForm').addEventListener('submit', function(event){

        event.preventDefault();
        // console.log('meng');

        const formData = new FormData(this);

    fetch('/api/rfid_borrow', {
      method: 'POST',
      body: formData,
    }).then(response => response.json())
    .then(data => {
      if(data.message == 'borrow successfully!'){
        document.getElementById('borrowForm').style.display = 'none';
        Swal.fire({
           icon: 'success',
           title: 'Borrow Successfully!',
           showConfirmButton: false,
           timer: 2500
       }).then(() => {
        window.location.reload();
       });
      }
    });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>
