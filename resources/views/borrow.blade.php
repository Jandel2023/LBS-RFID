<div class="modal fade" id="profileModalLabel" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="profileModalLabel">Profile</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        
          <div class="modal-body">
              <!-- Profile Form -->
              <form id="borrowBook">

              <input type="hidden" id="profileID"  name="profile_id">
              <div class="text-center mb-3">
                
                <img id="profilePicture" class="img-fluid rounded-circle" alt="Avatar" style="width: 150px; height:150px;">
                <!-- <img id="profileDefault" class="img-fluid rounded-circle" alt="Avatar" style="width: 150px; height:150px;"> -->

                
                <!-- <img id="profilePicturePreview" src="" class="img-fluid rounded-circle" alt="Avatar" style="width: 150px; height:150px;"> -->
            </div>

              <div class="text-center mb-3">
                <!-- <label for="profilePictureInput" class="btn btn-primary">
                    Choose Profile Picture
                    <input type="file" id="profilePictureInput" class="d-none" name="avatar"> -->
                </label>
            </div>
                  <div class="row">
                   
                        <!-- <input type="hidden" class="form-control" id="description" name="role" value="" required>
                        <input type="hidden" class="form-control" id="description" name="description" value=""  required> -->
                      <div class="col-md-3 mb-3">
                          <label for="firstName" class="form-label"><strong>RFID</strong></label>
                          <!-- <input  type="text" class="form-control @error('') is-invalid @enderror" id="first_name" name="first_name" value="" placeholder="Enter your first name" readonly > -->
                          <p id="rfid"></p>
                        </div>
                        <div class="col-md-3 mb-3">
                          <!-- <label for="middleName" class="form-label"><strong>Middle Name</strong></label>
                          <input type="text" class="form-control  @error('') is-invalid @enderror" id="middle_name" name="middle_name" value="" placeholder="Enter your middle name" readonly> -->
                          <label for="FullName" class="form-label"><strong>Full Name</strong></label>
                          
                          <p  id="full_name"></p>
                      </div>
                      <div class="col-md-3 mb-3">
                          <!-- <label for="lastName" class="form-label"><strong>Last Name</strong></label>
                          <input type="text" class="form-control  @error('') is-invalid @enderror" id="last_name" name="last_name" value="" placeholder="Enter your last name" readonly> -->
                          <!-- <p id="mid"></p> -->

                          <label for="Email" class="form-label"><strong>Email</strong></label>
                          
                          <p  id="email"></p>
                      </div>
                      <!-- <div class="col-md-3 mb-3">
                          <label for="email" class="form-label"><strong>Email</strong></label>
                          <input type="email" class="form-control  @error('') is-invalid @enderror" id="email" name="email" value="" placeholder="Enter your email" readonly>
                      </div> -->
                  </div>
              
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" id="createBorrower" class="btn btn-primary">Borrow</button>
          </div>
      </div>
  </div>
</div>
</form>

<script>
  document.getElementById('borrowBook').addEventListener('submit', function(event){

    event.preventDefault();

    const formData = new FormData(this);

    fetch('/api/rfid_borrow', {
      method: 'POST',
      body: formData,
    }).then(response => response.json())
    .then(data => {
      // console.log(data);
      if(data.message == 'borrow successfully!'){
        Swal.fire({
           icon: 'success',
           title: 'Borrow Successfully!',
           showConfirmButton: false,
           timer: 2500
       }).then(() => {
        window.location.href = '/';
       });
      }
    })
  })
</script>