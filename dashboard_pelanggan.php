<?php
session_start();  // memulai sesi pengguna
include(".includes/header_pelanggan.php"); // Menyertakan header untuk tampilan pelanggan
$title = "Dashboard_pelanggan";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
  // Redirect kalau bukan pelanggam
  header("Location: login.php");
  exit();
}

include(".includes/toast_notification.php");
?>
    <link rel="stylesheet" href="assets/css/main.css">

    <!-- Bagian utama halaman dengan background -->
<div class="container-xxl flex-grow-1 container-p-y bg-custom">
  <div class="welcome-text">
    <h2>SELAMAT DATANG DI SHOMERCE</h2> <!-- Pesan sambutan untuk pengguna -->
  </div>
</div>

<!-- Deskripsi tentang kategori produk -->
<div class="container">
  <div class="card card-shadow mt-4 mb-5">
    <div class="card-body text-center">
      <h2 class="fw-bold">Upgrade Hidupmu ke Level Selanjutnya</h2>
<p>Temukan berbagai kategori produk pilihan yang siap menemani aktivitas digitalmu setiap hari.</p>
</div>


<!-- Judul Kategori -->
<div class="container">
  <div class="card card-shadow mt-4 mb-3">
    <div class="card-body text-left">
      <h4 class="fw-bold">KATEGORI</h4>
    </div>
  </div>
</div>

<!-- Baris Kartu Kategori (4 Kartu Sejajar) -->
<div class="container-xxl">
  <div class="row justify-content-center">
    
    <div class="col-md-3 mb-4">
      <div class="card text-bg-dark border-0">
        <img class="card-img" src="assets/img/tampilan/hp.jpg" alt="Smart Phone">
        <div class="card-img-overlay d-flex align-items-end">
          <h5 class="card-title text-white">Smart Phone</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-bg-dark border-0">
        <img class="card-img" src="assets/img/tampilan/komputer.jfif" alt="Laptop">
        <div class="card-img-overlay d-flex align-items-end">
          <h5 class="card-title text-white">Computer</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-bg-dark border-0">
        <img class="card-img" src="assets/img/tampilan/mouse.webp" alt="Aksesoris">
        <div class="card-img-overlay d-flex align-items-end">
          <h5 class="card-title text-white">Mouse</h5>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-4">
      <div class="card text-bg-dark border-0">
        <img class="card-img" src="assets/img/tampilan/tv.jfif" alt="Kamera">
        <div class="card-img-overlay d-flex align-items-end">
          <h5 class="card-title text-white">Smart TV</h5>
        </div>
      </div>
    </div>
</div>
  </div>
</div>

<!-- Tombol Aksi di Bagian Akhir Halaman -->
<div class="container my-5">
    <div class="text-center">
      <a href="produk_pelanggan.php" class="btn btn-primary btn-lg px-5 py-3">
        Lihat Produk
      </a>
    </div>
</div>