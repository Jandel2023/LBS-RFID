<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to Borrow?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
        <div class="modal-body">
          <!-- Search input and button -->
          <div class="input-group mb-3">
            <!-- <input type="number" list="isbnList"> -->
            <input type="number" list="isbnList" class="form-control mr-2" id="search" placeholder="Search ISBN" style="width: 300px;">
            <datalist id="isbnList">
            <!-- <option value="1234567890"></option>
            <option value="0987654321"></option> -->
            </datalist>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" id="searchButton" type="button">Search</button>
            </div>
          </div>
          <!-- Error message -->
          <div id="errorMessage" class="text-danger mb-3" style="display: none;"></div>
          
          <!-- Horizontal table to display books -->
          <div id="bookDisplay" class="table-responsive" style="display:  none;">
            <table class="table table-bordered">
              <tbody id="bookTableBody">
                <tr>
                  <th scope="row">ISBN</th>
                  <td id="isbn">-</td>
                </tr>
                <tr>
                  <th scope="row">Title</th>
                  <td id="title">-</td>
                </tr>
                <tr>
                  <th scope="row">Author</th>
                  <td id="author">-</td>
                </tr>
                <tr>
                  <th scope="row">Category</th>
                  <td id="category">-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <form id="borrowedBook">
        <div class="modal-footer">
          <input type="hidden" id="borrowerId" name="borrower_id">
          <input type="hidden" id="bookId" name="book_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Borrow</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
 document.getElementById('searchButton').addEventListener('click', function(event) {
  event.preventDefault();

  const searchButton = document.getElementById('searchButton');
  searchButton.disabled = true;
  searchButton.textContent = 'Searching...';

  const searchQuery = document.getElementById('search').value;

  performSearch(searchQuery).finally(() => {
    searchButton.disabled = false;
    searchButton.textContent = 'Search';
  });
});

function performSearch(query) {
  let messageSearch = 'Please provide isbn';

  if(query == '' || query == null){
    searchButton.disabled = false;
    searchButton.textContent = 'Search';
    document.getElementById('errorMessage').style.display = 'block';
    document.getElementById('errorMessage').textContent = messageSearch;
    document.getElementById('submitBtn').disabled = true;
  }else{
    return fetch(`/api/searchBook/${query}`, {
    method: 'GET',
    headers: {
      Accept: 'application/json',
    }
  }).then(response => response.json())
  .then(response => {
    console.log(response);

    if(response.message == 'book not found!'){
      document.getElementById('errorMessage').style.display = 'block';
      document.getElementById('errorMessage').textContent = 'Book not found. Please try again!';
      document.getElementById('submitBtn').disabled = true;
    } else {
      document.getElementById('bookDisplay').style.display = 'block';
      document.getElementById('errorMessage').textContent = '';
      document.getElementById('isbn').textContent = response.book.isbn;
      document.getElementById('title').textContent = response.book.title;
      document.getElementById('author').textContent = response.book.author.full_name;
      document.getElementById('category').textContent = response.book.category.name;

      document.getElementById('bookId').value = response.book.id;

      document.getElementById('submitBtn').disabled = false;
    }
  });
  }
}
</script>
<script>
   document.getElementById('borrowedBook').addEventListener('submit', function (event){
    event.preventDefault();

    const submitButton = document.getElementById('submitBtn');
    submitButton.disabled = true; // Disable the button
    submitButton.textContent = 'Loading...'; // Set loading text

    const formData = new FormData(this);

    fetch('/api/borrow', {
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json',
      }
    }).then(response => response.json())
    .then(response => {
      console.log(response);
      if(response.message == 'borrowed') {
        document.getElementById('exampleModalCenter').classList.remove('show');
        document.getElementById('exampleModalCenter').style.display = 'none';
        document.body.classList.remove('modal-open');
        document.querySelector('.modal-backdrop').remove(); 
        document.getElementById('borrowedBook').reset();
        document.getElementById('bookDisplay').style.display = 'none';
        submitButton.disabled = true; 
        submitButton.textContent = 'Save changes'; // Reset button text

        document.getElementById('search').value = '';
        Swal.fire({
          title: "Borrowed Successfully!",
          icon: "success"
        });
      } else {
        submitButton.disabled = false; // Re-enable the button if an error occurs
        submitButton.textContent = 'Save changes';
      }
    });
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

  console.log(data.status);
  if(data.status == 200){

    console.log(data);
    // document.addEventListener('DOMContentLoaded', function (){
    
      fetch('/api/bookIsbn', {
        method: 'GET',
        headers: {
          Accept: 'application/json',
        }
      }).then(response => response.json())
      .then(res => {
    
        // console.log(res);

        if(Array.isArray(res.isbn)){
          const dataList = document.getElementById('isbnList');
          dataList.innerHTML = '';
    
          res.isbn.forEach( isbn => {
            // console.log(isbn);
            let option = document.createElement('option');
            option.value = isbn;
            // console.log(option.value);
            dataList.appendChild(option);
          });
        }
        // console.log(data.isbn);
      });
    // });
  }
})

</script>
