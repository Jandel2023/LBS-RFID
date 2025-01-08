@extends('index')
@section('content')
    <style>
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

        @keyframes blink {

            0%,
            100% {
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
    <div class="container-fluid">
        <div id="section1" class="container">
            <div class="loading-container">
                <div class="loading-spinner"></div>
                <p class="loading-text fs-9">Waiting for card...</p>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
            </div>
        </div>
        <div class="text-end mb-3" id="actionButton" style="display: none;">
            <button type="button" id="refreshButton" class="btn btn-success btn-sm">Reload</button>
        </div>
        <div class="card">
            <div class="card-body d-flex align-items-center justify-content-between">
                <!-- Left Side: Name, RFID, and Email -->
                <div class="text-start">
                    <h1 class="mb-3" id="full_name"></h1>
                    <p class="mb-3 fs-7"><b>RFID</b>: <span id="rfid" style="color: blue"></span></p>
                    <p class="mb-2 fs-7"><b>Email</b>: <span id="email"></span></p>
                </div>

                <!-- Right Side: Profile Image -->
                <div class="text-end">
                    <img style="display: none;" id="profilePicture" alt="Profile Image" class="rounded-circle"
                        width="200" height="200">
                    <img src="https://via.placeholder.com/150" alt="Profile Image" id="profilePictureTemporary"
                        class="rounded-circle" width="200" height="200">

                </div>
            </div>

            <!-- Button with Loading Symbol -->
            <div class="d-flex justify-content-center mt-3 mb-3">
                <button type="button" class="btn btn-primary" id="borrowButton" style="display: none">
                    <span id="buttonText">Borrow</span>
                    <div id="loader" class="spinner-border spinner-border-sm text-light" role="status"
                        style="display: none;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>
                <a style="display: none;" id="btnCancel" class="btn btn-cancel" href="/">Cancel</a>

            </div>
        </div>
        <div id="borrowedBooks" class="card" style="display: none;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Borrowed</h5>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Borrow
                        Book</button>
                </div>
                <div class="mb-3" style="width: 30%;">
                    <input type="text" id="bookSearchList" class="form-control" placeholder="Search books...">
                </div>

                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table text-nowrap align-middle mb-0" id="bookList">
                        <thead>
                            <tr class="border-2 border-bottom border-primary border-0">
                                <th scope="col" class="ps-0">No.</th>
                                <th scope="col" class="ps-0">Title</th>
                                <th scope="col">ISBN</th>
                                <th scope="col" class="text-center">Author</th>
                                <th scope="col" class="text-center">Category</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider" id="tBody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @include('layout_page.books.borrow_modal')
        @include('layout_page.books.return_modal')

        <!-- JavaScript for Search Filtering -->




        <!-- <script>
            document.getElementById('borrowedBook').addEventListener('submit', function(event) {

                event.preventDefault();

                const formData = new FormData(this);
                fetch('/api/borrow', {
                    method: 'POST',
                    body: formData,
                }).then(response => {
                    return response.json();
                }).then(response => {
                    console.log(response);
                })

            });
        </script> -->

        <script>
            // Get the button, text, and loader elements
            const borrowButton = document.getElementById('borrowButton');
            const buttonText = document.getElementById('buttonText');
            const loader = document.getElementById('loader');
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));

            // Add an event listener for the button click
            borrowButton.addEventListener('click', function() {
                // Hide the text and show the loader
                buttonText.style.display = 'none';
                loader.style.display = 'inline-block';

                // Simulate a delay (for example, 3 seconds)
                setTimeout(function() {
                    // After the delay, reset the button text and hide the loader
                    loader.style.display = 'none';
                    buttonText.style.display = 'inline-block';
                }, 1000); // Adjust time as needed

                myModal.show();
            });
        </script>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script>
            Pusher.logToConsole = true;

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            });

            var channel = pusher.subscribe('RFID-channel');

            channel.bind('RFID-channel', function(data) {
                if (data.status == 200) {

                    // console.log(data);
                    let profilePicture = document.getElementById('profilePicture');

                    document.getElementById('actionButton').style.display = 'block';
                    document.getElementById('section1').style.display = 'none';
                    // document.getElementById('borrowButton').style.display = 'block';
                    document.getElementById('profilePictureTemporary').style.display = 'none';
                    // document.getElementById('btnCancel').style.display = 'block';
                    document.getElementById('borrowedBooks').style.display = 'block';
                    profilePicture.style.display = 'block';

                    // document.getElemsentById('profile-container').style.display = 'block';

                    // document.getElementById('profile_id').value = data.user.id;
                    document.getElementById('rfid').textContent = data.user.rfid;
                    document.getElementById('full_name').textContent = data.user.full_name;
                    document.getElementById('email').textContent = data.user.email;

                    console.log(data.borrower.id);
                    document.getElementById('borrowerId').value = data.borrower.id;
                    document.getElementById('book_borrower_input').value = data.borrower.id;


                    document.getElementById('borrowedBooks').style.display = 'block';


                    if (data.user.profile_img == null) {
                        profilePicture.src = 'storage/profile_default.png';
                    } else {
                        profilePicture.src = data.user.profile_img;
                    }

                    fetch(`/api/listOfBook/${data.user.id}`, {
                        method: 'GET',
                        headers: {
                            Accept: 'application/json',
                        },
                    }).then(response => {
                        return response.json();
                    }).then(response => {

                        console.log(response.borrowed.borrowed_books);
                        let tBody = document.getElementById('tBody');
                        tBody.innerHTML = '';

                        response.borrowed.borrowed_books.sort((a, b) =>
                            new Date(b.created_at) - new Date(a.created_at)
                        );

                        document.addEventListener('click', function(event) {
                            if (event.target.matches('.btn-warning')) {
                                let bookId = event.target.getAttribute('data-id'); // Get the book ID
                                let bookTitle = event.target.getAttribute(
                                    'data-title'); // Get the book title

                                // Set values in modal
                                document.getElementById('book_id_input').value =
                                    bookId; // Hidden input for ID
                                document.getElementById('book_title').innerText =
                                    bookTitle; // Display title in modal
                            }
                        });



                        for (let i = 0; i < response.borrowed.borrowed_books.length; i++) {
                            let index = i + 1;

                            // Check the status of the book
                            let isBorrowed = response.borrowed.borrowed_books[i]
                                .status; // Assuming 'status' is a boolean

                            // Create action column content based on status
                            let action = isBorrowed ?
                                `<button class="btn btn-warning btn-sm"
               data-toggle="modal"
               data-target="#returnModalCenter"
               data-id="${response.borrowed.borrowed_books[i].book.id}"
               data-title="${response.borrowed.borrowed_books[i].book.title}">
          Return
       </button>` :
                                '<span class="badge bg-danger">Returned</span>';

                            // Generate the table row
                            let row = '<tr>' +
                                '<th scope="row">' + index + '</th>' +
                                '<th scope="row" class="ps-0 fw-medium">' +
                                '<span class="table-link1 text-truncate d-block">' +
                                response.borrowed.borrowed_books[i].book.title +
                                '</span>' +
                                ' </th>' +
                                ' <td>' + response.borrowed.borrowed_books[i].book.isbn + '</td>' +
                                ' <td class="text-center fw-medium">' +
                                response.borrowed.borrowed_books[i].book.author.full_name +
                                '</td>' +
                                ' <td class="text-center fw-medium">' +
                                response.borrowed.borrowed_books[i].book.category.name +
                                '</td>' +
                                ' <td class="text-center">' + action + '</td>' + // Add action column
                                '</tr>';

                            tBody.innerHTML += row;
                        }

                        // console.log(response.borrowed.id);
                        // document.getElementById('borrowed_id').value = response.borrowed.id;
                    })

                    // //Borrowed Book Lists


                } else {
                    // document.getElementById('section1').style.display = 'none';
                    // document.getElementById('profile-container').style.display = 'none';

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
        <script>
            // Select the refresh button
            const refreshButton = document.getElementById('refreshButton');

            // Add click event listener
            refreshButton.addEventListener('click', function(event) {
                event.preventDefault();

                // Disable the button
                refreshButton.disabled = true;

                // Create the loader (spinner)
                const loader = document.createElement('span');
                loader.style.border = '4px solid #f3f3f3';
                loader.style.borderTop = '4px solid #3498db';
                loader.style.borderRadius = '50%';
                loader.style.width = '16px';
                loader.style.height = '16px';
                loader.style.animation = 'spin 1s linear infinite';
                loader.style.display = 'inline-block';
                loader.style.marginRight = '8px';

                // Add spinner and countdown text
                refreshButton.innerHTML = ''; // Clear current content
                refreshButton.appendChild(loader); // Append spinner
                const countdownText = document.createTextNode(' Reloading in 3...');
                refreshButton.appendChild(countdownText);

                // Countdown logic
                let count = 3;
                const countdown = setInterval(() => {
                    count--;
                    countdownText.textContent = ` Reloading in ${count}...`;

                    if (count <= 0) {
                        clearInterval(countdown);
                        window.location.reload(); // Reload the page
                    }
                }, 1000);
            });

            // Add keyframes dynamically for loader animation
            const style = document.createElement('style');
            style.type = 'text/css';
            style.innerHTML = `
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
`;
            document.head.appendChild(style);
        </script>

        <script>
            document.getElementById('bookSearchList').addEventListener('keyup', function() {
                let input = this.value.toLowerCase();
                let rows = document.querySelectorAll('#bookList tbody tr');

                rows.forEach(row => {
                    let title = row.cells[1].textContent.toLowerCase();
                    let isbn = row.cells[2].textContent.toLowerCase();
                    let author = row.cells[3].textContent.toLowerCase();
                    let category = row.cells[4].textContent.toLowerCase();

                    if (title.includes(input) || author.includes(input) || category.includes(input) || isbn
                        .includes(input)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
    @endsection
