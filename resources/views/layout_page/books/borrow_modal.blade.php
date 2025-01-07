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
            <input type="number" class="form-control mr-2" id="searchInput" placeholder="Search ISBN" style="width: 300px;">
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
          <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
  document.getElementById('searchButton').addEventListener('click', function(event) {
  // Prevent the default button behavior (form submission)
  event.preventDefault();

  // Get the value entered in the search input
  const searchQuery = document.getElementById('searchInput').value;

  // Perform your search operation here

  // Example: Replace this with an actual search function
  performSearch(searchQuery);
});

// Example function for search
function performSearch(query) {

  let messageSearch = 'Please provide isbn';

  if(query == '' || query == null){
    document.getElementById('errorMessage').style.display = 'block';
    document.getElementById('errorMessage').textContent = messageSearch;
    document.getElementById('submitBtn').disabled = true; // Disable save changes
  }else{
    fetch(`/api/searchBook/${query}`, {
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
      document.getElementById('submitBtn').disabled = true; // Disable save changes
    } else {
      document.getElementById('bookDisplay').style.display = 'block';
      document.getElementById('errorMessage').textContent = '';
      document.getElementById('isbn').textContent = response.book.isbn;
      document.getElementById('title').textContent = response.book.title;
      document.getElementById('author').textContent = response.book.author.full_name;
      document.getElementById('category').textContent = response.book.category.name;

      document.getElementById('bookId').value = response.book.id;

      document.getElementById('submitBtn').disabled = false; // Enable save changes
    }
  });
  }
}
</script>
<script>
  document.getElementById('borrowedBook').addEventListener('submit', function (event){

    event.preventDefault();

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
        document.getElementById('borrowedBook').reset(); // Reset form
        document.getElementById('bookDisplay').style.display = 'none'; // Hide book display
        document.getElementById('submitBtn').disabled = true; // Disable save button

        Swal.fire({
  title: "Borrowed Successfully!",
  // text: "You clicked the button!",
  icon: "success"
    });
      }
    });
  });
</script>
