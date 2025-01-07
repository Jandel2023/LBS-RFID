<!-- Modal -->
<div class="modal fade" id="returnModalCenter" tabindex="-1" role="dialog" aria-labelledby="returnModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Return Book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="returnBook">
            <div class="modal-body">
                <!-- Hidden Input Field for book_id -->
                <input type="hidden" id="book_borrower_input" name="borrower_id">
                <input type="hidden" id="book_id_input" name="book_id" />
                <!-- Display Book Title -->
                <p>Are you sure you want to return the book titled: <strong id="book_title" class="text-danger"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="confirmBtn">
                    <span id="confirmBtnText">Confirm</span>
                    <span id="confirmLoader" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
  document.getElementById('returnBook').addEventListener('submit', function (event){
    event.preventDefault();

    const confirmBtn = document.getElementById('confirmBtn');
    const confirmBtnText = document.getElementById('confirmBtnText');
    const confirmLoader = document.getElementById('confirmLoader');

    // Show loader and disable button
    confirmBtn.disabled = true;
    confirmBtnText.classList.add('d-none');
    confirmLoader.classList.remove('d-none');

    const formData = new FormData(this);

    fetch('/api/return', {
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json',
      }
    }).then(response => response.json())
    .then(response => {
      console.log(response);
      if(response.message == 'returned'){
        document.getElementById('returnModalCenter').classList.remove('show');
        document.getElementById('returnModalCenter').style.display = 'none';
        document.body.classList.remove('modal-open');
        document.querySelector('.modal-backdrop').remove(); 

        Swal.fire({
          title: "Returned Successfully!",
          icon: "success"
        });
      }
    }).finally(() => {
      // Hide loader and enable button
      confirmBtn.disabled = false;
      confirmBtnText.classList.remove('d-none');
      confirmLoader.classList.add('d-none');
    });
  })
</script>