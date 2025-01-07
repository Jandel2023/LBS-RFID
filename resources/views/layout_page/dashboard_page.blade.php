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
<div class="container-fluid">
<div id="section1" class="container" >
        <div class="loading-container">
            <div class="loading-spinner"></div>
            <p class="loading-text fs-9">Waiting for card...</p>
        </div>
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
        <img style="display: none;" id="profilePicture" alt="Profile Image" class="rounded-circle" width="200" height="200">
        <img src="https://via.placeholder.com/150" alt="Profile Image" id="profilePictureTemporary" class="rounded-circle" width="200" height="200">

      </div>
    </div>

    <!-- Button with Loading Symbol -->
    <div class="d-flex justify-content-center mt-3 mb-3">
      <button type="button" class="btn btn-primary" id="borrowButton" style="display: none">
        <span id="buttonText">Borrow</span>
        <div id="loader" class="spinner-border spinner-border-sm text-light" role="status" style="display: none;">
          <span class="visually-hidden">Loading...</span>
        </div>
      </button>
      <a style="display: none;" id="btnCancel" class="btn btn-cancel"  href="/">Cancel</a>

    </div>
  </div>
  <div id="borrowedBooks" class="card" style="display: none;">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="card-title mb-0">Borrowed</h5>
      <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Borrow Book</button>
    </div>

    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
      <table class="table text-nowrap align-middle mb-0">
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

<!-- JavaScript for Search Filtering -->




<!-- <script>
      document.getElementById('borrowedBook').addEventListener('submit', function (event){

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
    }, 1000);  // Adjust time as needed

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

        channel.bind('RFID-channel', function (data) {
            if (data.status == 200) {

                // console.log(data);
                let profilePicture =  document.getElementById('profilePicture');

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

                document.getElementById('borrowerId').value = data.borrower.id;

                document.getElementById('borrowedBooks').style.display = 'block';


                if (data.user.profile_img == null) {
                    profilePicture.src = 'storage/profile_default.png';
                } else {
                    profilePicture.getElementById('profilePicture').src = data.user.profile_img;
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

                for(let i = 0; i < response.borrowed.borrowed_books.length; i++){

                   let index = i + 1;
                   
                   let row = '<tr>' + 
                          '<th scope="row">'+ index  + '</th>' +
                          '<th scope="row" class="ps-0 fw-medium">' + 
                           '<span class="table-link1 text-truncate d-block">' +
                            response.borrowed.borrowed_books[i].book.title +
                            '</span>' +
                            ' </th>' +
                            ' <td>' + response.borrowed.borrowed_books[i].book.isbn + '</td>' +
                            ' <td class="text-center fw-medium">' + response.borrowed.borrowed_books[i].book.author.full_name +
                            '</td>' +
                             ' <td class="text-center fw-medium">'+ response.borrowed.borrowed_books[i].book.category.name + '</td>'
                             +
                            '</tr>';

                            tBody.innerHTML += row;
                }

                // console.log(response.borrowed.id);
                // document.getElementById('borrowed_id').value = response.borrowed.id;
                })

                // //Borrowed Book Lists

                
            }else{
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

