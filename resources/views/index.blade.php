<!DOCTYPE html>
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

</html>
