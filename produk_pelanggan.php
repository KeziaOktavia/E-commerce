
<?php
session_start();
include(".includes/header_pelanggan.php");
$title = "Dashboard_pelanggan";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
  header("Location: login.php");
  exit();
}

include(".includes/toast_notification.php");
require_once("config.php");


// Ambil data pencarian dari query string jika ada
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data produk dan kategori terkait
$query = "SELECT produk.produk_id, produk.namaProduk, produk.image_path, produk.harga, produk.stok, kategori.nama_kategori 
      FROM produk 
      LEFT JOIN kategori ON produk.kategori_id = kategori.kategori_id";

// Jika ada kata kunci pencarian, tambahkan filter WHERE ke query
if (!empty($search)) {
    $search = mysqli_real_escape_string($conn, $search); // Sanitasi input pencarian
    $query .= " WHERE produk.namaProduk LIKE '%$search%' OR kategori.nama_kategori LIKE '%$search%'";
}

$exec = mysqli_query($conn, $query); // Eksekusi query ke database
?>

<!-- Container agar sejajar dengan navbar -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card card-biru-shadow mb-4">
    <div class="card-body text-center">
      <h2 class="fw-bold">Produk Yang Tersedia</h2>
      <h5 class="mb-0">Temukan berbagai produk terbaik kami dengan harga terjangkau.</h5>
    </div>
  </div>

  <!-- Form pencarian produk -->
  <form method="GET" class="mb-4">
    <div class="input-group input-group-lg">
      <input type="text" name="search" class="form-control" placeholder="Cari Nama Produk dan Kategori disini" value="<?= htmlspecialchars($search); ?>">
      <button class="btn btn-primary" type="submit">Cari</button>
      <?php if (!empty($search)): ?>
        <a href="produk_pelanggan.php" class="btn btn-outline-secondary">Reset</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Pesan jika tidak ada produk yang ditemukan -->
  <?php if (mysqli_num_rows($exec) == 0): ?>
    <p class="text-center">Tidak ada produk yang ditemukan untuk pencarian Anda.</p>
  <?php endif; ?>

  <!-- Daftar Produk -->
  <div class="row">
    <?php while ($produk = mysqli_fetch_assoc($exec)): ?>
      <div class="col-md-5 col-lg-3 mb-5">
        <div class="card h-100 d-flex flex-column">
          <!-- Tampilkan gambar produk jika ada dan file ada, jika tidak tampilkan gambar default -->
          <?php if (!empty($produk['image_path']) && file_exists($produk['image_path'])): ?>
            <img src="<?= $produk['image_path']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Gambar Produk">
          <?php else: ?>
            <img src="assets/img/no-image.png" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Tidak Ada Gambar">
          <?php endif; ?>
          
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($produk['namaProduk']); ?></h5>
            <!-- Bintang rating -->
            <div class="card-body">
          <div class="read-only-ratings raty" data-read-only="true" data-score="3" data-number="5" title="regular" style="pointer-events: none;">
            <img alt="1" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='22' %3E%3Cpath fill='%23FFD700' d='M21.947 9.179a1 1 0 0 0-.868-.676l-5.701-.453l-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107l-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4l4.536-4.082c.297-.268.406-.686.278-1.065'/%3E%3C/svg%3E" title="regular">&nbsp;
            <img alt="2" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='22' %3E%3Cpath fill='%23FFD700' d='M21.947 9.179a1 1 0 0 0-.868-.676l-5.701-.453l-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107l-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4l4.536-4.082c.297-.268.406-.686.278-1.065'/%3E%3C/svg%3E" title="regular">&nbsp;
            <img alt="3" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='22' %3E%3Cpath fill='%23FFD700' d='M21.947 9.179a1 1 0 0 0-.868-.676l-5.701-.453l-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107l-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4l4.536-4.082c.297-.268.406-.686.278-1.065'/%3E%3C/svg%3E" title="regular">&nbsp;
            <img alt="4" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='22' %3E%3Cpath fill='%23FFD700' d='M21.947 9.179a1 1 0 0 0-.868-.676l-5.701-.453l-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107l-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4l4.536-4.082c.297-.268.406-.686.278-1.065'/%3E%3C/svg%3E" title="regular">&nbsp;
            <img alt="5" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='20' height='22' %3E%3Cpath fill='rgb(228,230,232)' d='M21.947 9.179a1 1 0 0 0-.868-.676l-5.701-.453l-2.467-5.461a.998.998 0 0 0-1.822-.001L8.622 8.05l-5.701.453a1 1 0 0 0-.619 1.713l4.213 4.107l-1.49 6.452a1 1 0 0 0 1.53 1.057L12 18.202l5.445 3.63a1.001 1.001 0 0 0 1.517-1.106l-1.829-6.4l4.536-4.082c.297-.268.406-.686.278-1.065'/%3E%3C/svg%3E" title="regular"><input name="score" type="hidden" value="3" readonly=""></div>
        </div>
            <!-- Informasi produk -->
            <p class="card-text mb-1"><strong>Kategori:</strong> <?= htmlspecialchars($produk['nama_kategori']); ?></p>
            <p class="card-text mb-1"><strong>Harga:</strong> Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></p>
            <p class="card-text mb-3"><strong>Stok:</strong> <?= (int) $produk['stok']; ?></p>

            
            <!-- Tombol dan modal pemesanan produk -->
            <div class="mt-auto">
            <!-- Tombol untuk membuka modal pesan -->
             <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPesan_<?= $produk['produk_id']; ?>">Pesan</button>

<!-- Modal Pesan produk -->
<div class="modal fade" id="modalPesan_<?= $produk['produk_id']; ?>" tabindex="-1" aria-labelledby="modalPesanLabel_<?= $produk['produk_id']; ?>" aria-hidden="true">
  <div class="modal-dialog">
    <form action="proses_pesanan.php" method="POST">
      <input type="hidden" name="produk_id" value="<?= $produk['produk_id']; ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPesanLabel_<?= $produk['produk_id']; ?>">Pesan Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
                                
        <!-- Info produk di modal -->
        <div class="modal-body">
          <p><strong>Nama Produk:</strong> <?= htmlspecialchars($produk['namaProduk']); ?></p>
          <p><strong>Harga Satuan:</strong> Rp<?= number_format($produk['harga'], 0, ',', '.'); ?></p>
          <p><strong>Stok Tersedia:</strong> <?= (int) $produk['stok']; ?></p>

          <!-- Input jumlah pesanan dengan validasi min dan max -->
          <div class="mb-3">
            <label for="jumlah_<?= $produk['produk_id']; ?>" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah_<?= $produk['produk_id']; ?>" name="jumlah" min="1" max="<?= (int) $produk['stok']; ?>" required oninput="updateTotalPrice(<?= $produk['produk_id']; ?>, <?= $produk['harga']; ?>)">
          </div>

        <div class="mb-3">
  <label for="total_harga_<?= $produk['produk_id']; ?>" class="form-label">Total Harga</label>
  <input type="text" class="form-control" id="total_harga_<?= $produk['produk_id']; ?>" name="total_harga" readonly />
  <!-- Tambahkan ID yang sesuai agar bisa diakses dari JS -->
  <input type="hidden" name="total" id="total_hidden_<?= $produk['produk_id']; ?>" />
</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
        </div>
      </div>
    </form>
  </div>
</div>
          </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>


<!-- Script untuk menghitung Total Harga -->
<script>
  // Fungsi untuk menghitung dan menampilkan total harga berdasarkan jumlah produk yang dipilih
 function updateTotalPrice(produk_id, harga) {
    // Ambil nilai jumlah produk yang dimasukkan user dari input dengan id 'jumlah_' + produk_id
    const jumlah = document.getElementById('jumlah_' + produk_id).value;
    // Hitung total harga = harga produk dikali jumlah produk yang dipilih
    const totalHarga = harga * jumlah;

    // Tampilkan total harga dalam format Rupiah di kotak input yang bisa dilihat tapi nggak bisa diubah sama user
    // Fungsi toLocaleString('id-ID') bikin angka dipisah pakai tanda titik sesuai cara penulisan angka di Indonesia
    document.getElementById('total_harga_' + produk_id).value = "Rp " + totalHarga.toLocaleString('id-ID');

    // Simpan total harga yang asli (angka biasa, nggak ada Rp atau tanda titik) di input yang nggak kelihatan
    // Biar waktu data dikirim ke server, nilainya gampang dipakai buat proses selanjutnya
    document.getElementById('total_hidden_' + produk_id).value = totalHarga;
}
</script>
<!-- Footer -->
<?php include '.includes/footer.php'; ?>