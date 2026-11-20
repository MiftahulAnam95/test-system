<?php
require_once __DIR__ . '/../config/config_path.php';
$current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$current_file = basename($current_path);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Test System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= BASE_URL ?>template/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>template/assets/images/favicon.png" />

  <style>
    /* CSS yang sudah ada */
    .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini img {
        width: calc(75px - 42px);
    }

    .navbar .navbar-brand-wrapper .navbar-brand img {
        width: calc(249px - 82px);
    }

    @media (min-width: 992px) {
        .sidebar-icon-only .navbar .navbar-brand-wrapper .brand-logo-mini {
            display: contents;
        }
    }

    .sidebar .nav .nav-item {
        padding: 0 2.1rem;
    }

    /* CSS baru untuk memperbaiki logo mini di mobile */
    @media (max-width: 991.98px) {
        .navbar-brand-wrapper .brand-logo-mini img {
            width: auto !important;
            height: 40px !important; /* Sesuaikan tinggi sesuai kebutuhan */
            max-height: 40px !important;
            margin-left: 30px !important; /* Tambahkan margin kiri untuk ruang */
        }
        
        .navbar-brand-wrapper .navbar-brand.brand-logo-mini {
            padding: 5px 0; /* Tambahkan padding untuk ruang yang lebih baik */
        }
    }

    /* Optional: Untuk tampilan yang lebih baik di layar sangat kecil */
    @media (max-width: 576px) {
        .navbar-brand-wrapper .brand-logo-mini img {
            height: 35px !important;
            max-height: 35px !important;
        }
    }
  </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
          <a class="navbar-brand brand-logo" href="dashboard.php"><img src="<?= BASE_URL ?>template/assets/images/logo.svg" alt="logo" style="height: 38px;" /></a>
          <a class="navbar-brand brand-logo-mini" href="dashboard.php"><img src="<?= BASE_URL ?>template/assets/images/logo-mini.svg" alt="logo"/></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="pc-h-item me-2">
              <span class="">Sisa sesi : <strong id="session-time"></strong></span>
            </li>
            
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <?php include __DIR__ . "/../photo_profile.php"; ?>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?php echo htmlspecialchars($nama_user); ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="http://localhost/test-sso/logout.php?url=<?php echo $current_domain ?>">
                  <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/test-produk?url=<?php echo $current_domain ?>" target="_blank">
                <span class="menu-title">Produk Master</span>
                <i class="mdi mdi-package-variant menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/test-katprod?url=<?= $current_domain ?>" target="_blank">
                <span class="menu-title me-2">Kategori Produk & Merek</span>
                <i class="mdi mdi-tag menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost:8086?url=<?php echo $current_domain ?>" target="_blank">
                <span class="menu-title">Supplier Master</span>
                <i class="mdi mdi-truck menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost:8087?url=<?php echo $current_domain ?>" target="_blank">
                <span class="menu-title">Customer Master</span>
                <i class="mdi mdi-account menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/test-ketprod?url=<?= $current_domain ?>" target="_blank">
                <span class="menu-title">Keterangan Produk</span>
                <i class="mdi mdi-note-text menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/test-bank?url=<?= $current_domain ?>" target="_blank">
                <span class="menu-title">Bank Center Master</span>
                <i class="mdi mdi-bank menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="http://localhost/data-wilayah?url=<?php echo $current_domain ?>" target="_blank">
                <span class="menu-title">Data Wilayah Master</span>
                <i class="mdi mdi-map-marker menu-icon"></i>
              </a>
            </li>
          </ul>
        </nav>

<script>
    // Fungsi untuk memperbarui waktu sesi yang tersisa
    function updateSessionTime() {
        var sessionTime = <?php echo $session_time; ?>;
        var lastActivity = <?php echo isset($_SESSION['last_activity']) ? $_SESSION['last_activity'] : 0; ?>;
        var currentTime = Math.floor(Date.now() / 1000); // Waktu saat ini dalam detik
        var elapsedTime = currentTime - lastActivity;
        var remainingTime = sessionTime - elapsedTime;

        if (remainingTime <= 0) {
            document.getElementById('session-time').textContent = '00:00';
            window.location.href = 'http://localhost/test-sso/logout.php?url=<?php echo $current_domain ?>';
            return; 
        }

        // Konversi ke menit dan detik
        var minutes = Math.floor(remainingTime / 60);
        var seconds = remainingTime % 60;

        // Tambahkan angka nol di depan angka satu digit
        if (minutes < 10) minutes = '0' + minutes;
        if (seconds < 10) seconds = '0' + seconds;

        // Perbarui elemen HTML
        document.getElementById('session-time').textContent = minutes + ':' + seconds;

        // Panggil lagi fungsi ini setiap detik
        setTimeout(updateSessionTime, 1000);
    }

    // Panggil fungsi saat halaman dimuat
    updateSessionTime();
</script>
