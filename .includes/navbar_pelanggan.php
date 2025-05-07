<!-- Navbar -->
 <!-- box di atas buat navbar -->
 <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
      <i class="bx bx-menu bx-sm"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
    
    <!-- Logo -->
    <a class="navbar-brand fw-bold d-flex align-items-center fs-4 me-auto" href="#">
      <img src="assets/img/logo/logo.jpeg" alt="Logo" width="65" height="52" class="d-inline-block align-text-top">
      SHOMERCE
    </a>

    <!-- Navbar Menu -->
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="dashboard_pelanggan.php">HOME |</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">PRODUK |</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="detail_pesanan.php">DETAIL PEMESANAN |</a>
      </li>
      <li class="nav-item ms-2">
        <a href="auth/logout.php" class="btn btn-danger">
          <i class="bx bx-power-off me-md-1"></i>
          <span class="d-none d-md-inline">Logout</span>
        </a>
      </li>
    </ul>

  </div>
</nav>
<!-- / Navbar -->
