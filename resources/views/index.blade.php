<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RFID - Library System</title>
  <!-- <link rel="shortcut icon" type="image/png" /> -->
  <link rel="stylesheet" href="welcome_theme/assets/css/styles.min.css" />
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
    
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu"></span>
            </li>
            <li class="sidebar-item">
  <a class="sidebar-link" href="/home" aria-expanded="false">
    <span>
      <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
    </span>
    <span class="hide-menu">Home</span>
  </a>
</li>

            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">COMPONENTS</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('book.index')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">List of Books</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:danger-circle-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Alerts</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-card.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:bookmark-square-minimalistic-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Card</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-forms.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Forms</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="./ui-typography.html" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:text-field-focus-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Typography</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
              <span class="hide-menu"></span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="{{route('login')}}" aria-expanded="false">
                <span>
                  <iconify-icon icon="solar:login-3-bold-duotone" class="fs-6"></iconify-icon>
                </span>
                <span class="hide-menu">Login</span>
              </a>
            </li>
          </ul>
          
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
            <h1 class="text-center">RFID-Library System</h1>
          
        </nav>
      </header>
      <!--  Header End -->
        @yield('content')
      
    </div>
  </div>
  <script src="welcome_theme/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="welcome_theme/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="welcome_theme/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="welcome_theme/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="welcome_theme/assets/js/sidebarmenu.js"></script>
  <script src="welcome_theme/assets/js/app.min.js"></script>
  <script src="welcome_theme/assets/js/dashboard.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function () {
  const sidebarLinks = document.querySelectorAll(".sidebar-link"); // Select all sidebar links

  // Function to remove active class from all links
  function removeActiveClasses() {
    sidebarLinks.forEach(link => link.classList.remove("active"));
  }

  // Loop through each sidebar link
  sidebarLinks.forEach(link => {
    link.addEventListener("click", function () {
      // Remove 'active' class from all links first
      removeActiveClasses();

      // Add 'active' class to the clicked link
      link.classList.add("active");
    });
  });

  // Set the default active link based on the current URL
  const currentUrl = window.location.pathname;
  let isActiveSet = false;

  sidebarLinks.forEach(link => {
    if (link.getAttribute("href") === currentUrl) {
      link.classList.add("active"); // Set active class if URL matches
      isActiveSet = true;
    }
  });

  // If no active link is set, set 'Home' as the default active link
  // if (!isActiveSet) {
  //   const homeLink = document.querySelector(".sidebar-link[href='/home']");
  //   if (homeLink) {
  //     homeLink.classList.add("active");
  //   }
  // }
});


</script>

</body>

</html>