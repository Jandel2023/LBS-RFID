<div id="borrowedBooks" class="card">
  <div class="card-body">
    <h5 class="card-title">Books</h5>

    <!-- Search Input -->
    <div class="mb-3" style="width: 30%;">
      <input type="text" id="bookSearch" class="form-control" placeholder="Search books...">
    </div>

    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
      <table class="table text-nowrap align-middle mb-0" id="booksTable">
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
        <tbody class="table-group-divider">
          @foreach ($books as $book)
            <tr>
              <th scope="row">{{++$i}}</th>
              <th scope="row" class="ps-0 fw-medium">
                <span class="table-link1 text-truncate d-block"> {{$book->title}} </span>
              </th>
              <td>{{$book->isbn}}</td>
              <td class="text-center fw-medium">{{$book->author->full_name}}</td>
              <td class="text-center fw-medium">{{$book->category->name}}</td>
              <td class="text-center fw-medium"> 
              
      <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter{{$book->id}}">
  Borrow
        </a>

            </tr>
            @include('layout_page.books.borrow_modal')
          @endforeach
        </tbody>
      </table>
  </div>
</div>
<!-- Button trigger modal -->

<!-- JavaScript for Search Filtering -->
<script>
  document.getElementById('bookSearch').addEventListener('keyup', function () {
    let input = this.value.toLowerCase();
    let rows = document.querySelectorAll('#booksTable tbody tr');

    rows.forEach(row => {
      let title = row.cells[1].textContent.toLowerCase();
      let isbn = row.cells[2].textContent.toLowerCase();
      let author = row.cells[3].textContent.toLowerCase();
      let category = row.cells[4].textContent.toLowerCase();

      if (title.includes(input) || author.includes(input) || category.includes(input) || isbn.includes(input)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
</script>
