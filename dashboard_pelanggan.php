<?php
session_start();
include(".includes/header_pelanggan.php");
$title = "Dashboard_pelanggan";

// Cek apakah sudah login sebagai pelanggan
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
  // Redirect kalau bukan pelanggan
  header("Location: login.php");
  exit();
}
require_once("config.php");

// Ambil data pelanggan
$pelanggan_id = $_SESSION['pelanggan_id'];
$query = "SELECT nama, alamat FROM pelanggan WHERE pelanggan_id = $pelanggan_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_data'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Query untuk update data nama dan alamat
    $update_query = "
        UPDATE pelanggan 
        SET nama = '$nama', alamat = '$alamat' 
        WHERE pelanggan_id = $pelanggan_id";
         // Eksekusi query update
        mysqli_query($conn, $update_query);
// Arahkan kembali ke halaman dashboard setelah menyimpan, supaya halaman tidak ngirim data dua kali
    header("Location: dashboard_pelanggan.php");
    exit();
}
?>

<!-- Menghubungkan file CSS utama untuk styling -->
<link rel="stylesheet" href="assets/css/main.css">

<!-- Bagian selamat datang -->
<div class="container-xxl flex-grow-1 container-p-y bg-custom">
    <div class="welcome-text">
        <h2>SELAMAT DATANG DI SHOMERCE</h2>
    </div>
</div>

<!-- Panduan cara pesan produk -->
<div class="container mt-4">
    <div class="card border-start border-2 border-primary shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold text-primary">📌 Panduan Pemesanan Produk</h5>
        </div>
        <div class="card-body border-top">
            <ol class="fs-6 lh-lg mb-0">
                <li>Buka halaman <strong>Produk</strong> dengan klik tombol <i>"Lihat Produk"</i> atau di bagian atas halaman lalu tekan tulisan <i>"produk"</i>.</li>
                <li>Pilih produk yang ingin dipesan.</li>
                <li>Tekan tombol <strong>"Pesan"</strong> pada produk tersebut.</li>
                <li>Masukkan jumlah yang ingin dibeli.</li>
                <li><strong>Total harga</strong> akan langsung terhitung otomatis.</li>
                <li>Tekan tombol <strong>Konfirmasi</strong> untuk menyelesaikan pemesanan.</li>
                <li>Selesai! Tinggal tunggu status pesanan dari admin.</li>
            </ol>
        </div>
    </div>
</div>

<!-- Deskripsi tambahan sebelum kategori produk -->
<div class="container-xxl">
    <div class="card card-shadow mt-4 mb-5">
        
        <div class="card-body text-center">
            <h2 class="fw-bold">Upgrade Hidupmu ke Level Selanjutnya</h2>
            <p>Temukan berbagai kategori produk pilihan yang siap menemani aktivitas digitalmu setiap hari.</p>
        </div>
        
        <!-- Daftar kategori produk dengan gambar -->
        <div class="row justify-content-center">
        <div class="col-md-3 mb-4">
            <!-- kategori 1 -->
            <div class="card text-bg-dark border-0 mx-4 shadow">
                <img class="card-img" src="assets/img/tampilan/hp.jpg" alt="Smart Phone">
                <div class="card-img-overlay d-flex align-items-end">
                    <h5 class="card-title text-info">Smart Phone</h5>
                </div>
            </div>
        </div>
        <!-- kategori 2 -->
        <div class="col-md-3 mb-4">
            <div class="card text-bg-dark border-0 shadow">
                <img class="card-img" src="assets/img/tampilan/komputer.jfif" alt="Laptop">
                <div class="card-img-overlay d-flex align-items-end">
                    <h5 class="card-title text-white">Computer</h5>
                </div>
            </div>
        </div>
        <!-- kategori 3 -->
        <div class="col-md-3 mb-4">
            <div class="card text-bg-dark border-0 shadow">
                <img class="card-img" src="assets/img/tampilan/mouse.webp" alt="Aksesoris">
                <div class="card-img-overlay d-flex align-items-end">
                    <h5 class="card-title text-white">Mouse</h5>
                </div>
            </div>
        </div>
        <!-- kategori 4 -->
        <div class="col-md-3 mb-4">
            <div class="card text-bg-dark border-0 mx-4 shadow">
                <img class="card-img" src="assets/img/tampilan/tv.jfif" alt="Kamera">
                <div class="card-img-overlay d-flex align-items-end">
                    <h5 class="card-title text-white">Smart TV</h5>
                </div>
            </div>
        </div>
            <!-- Tombol lihat produk di bawah kategori -->
<div class="container my-3">
    <div class="text-center">
        <a href="produk_pelanggan.php" class="btn btn-primary btn-lg px-3 py-2">
            Lihat Produk
        </a>
    </div>
</div>
    </div>
    </div>
</div>

<!-- Bagian Edit Profil Pelanggan -->
<div class="container-xxl mt-5">
    <div class="card border border-primary shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">🔧 Edit Profil Anda</h5>
            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#editForm" aria-expanded="false" aria-controls="editForm">
                Edit Profil
            </button>
        </div>

        <!-- Form Edit Profil -->
        <div class="collapse" id="editForm">
            <div class="card-body bg-white">
                <form method="POST" action="">
                    <!-- Form Nama -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']); ?>" required>
                    </div>

                    <!-- Form Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($user['alamat']); ?></textarea>
                    </div>

                    <!-- Button Submit -->
                    <div class="text-end">
                        <button type="submit" name="update_data" class="btn btn-primary px-4">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include '.includes/footer.php'; ?>
