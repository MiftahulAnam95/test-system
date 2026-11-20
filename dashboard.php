<?php include 'akses.php';?>

<?php
require_once __DIR__ . '/includes/header.php';
?>

<style>
  /* Default max width 600px */
  .custom-img {
    max-width: 600px;
  }

  /* Saat layar mobile (<= 576px), ubah jadi 260px */
  @media (max-width: 576px) {
    .custom-img {
      max-width: 260px;
    }
  }
</style>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Dashboard
      </h3>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card border-0">
          <div class="card-body text-center p-5">
            <div class="mb-4">
              <i class="mdi mdi-web text-primary" style="font-size:60px;"></i>
            </div>
            <h2 class="fw-bold">Welcome to <span class="text-gradient-primary">Test System</span></h2>
            <p class="mt-3 text-muted">
              Website ini dibuat khusus untuk <strong>testing & pengembangan</strong> berbagai macam Sistem Website di PT. Karsa Mandiri Alkesindo.<br>
              Semua fitur, data, dan tampilan masih dalam tahap uji coba.
            </p>

            <!-- Tambahkan gambar di sini -->
            <div class="mt-4">
              <img src="template/assets/images/test-system.jpg" 
                  alt="Testing System" 
                  class="img-fluid rounded custom-img">
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
<!-- content-wrapper ends -->

<?php require_once 'includes/footer.php'; ?>