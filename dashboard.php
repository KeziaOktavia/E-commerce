<?php
session_start(); // Mulai session
include (".includes/header_admin.php");
$title = "Dashboard_admin";
// Menyertakan file untuk menampilkan notifikasi (jika ada)
include '.includes/toast_notification.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
<!-- Card untuk menampilkan tabel postingan -->
 <div class="card">
<!-- Tabel dengan baris yang dapat di-hover -->
 <div class="card">
<!-- Header Tabel -->
  <div class="card-header d-flex justify-content-between align-items-center">
    <h4>Semua Produk</h4>
</div>
<div class="card-body">
<!-- Tabel responsif -->
 <div class="table-responsive text-nowrap">
  <table id="datatable" class="table table-hover">
    <thead>
      <tr class="text-center">
        <th width="50px">#</th>
        <th>Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Kategori</th>
        <th width="150px">Pilihan</th>
</tr>
</thead>
<tbody class="table-border-bottom-0">
<!-- Menampilkan data dari tabel database -->
<?php
$index = 1; // Variabel untuk nomor urut

// Query untuk mengambil data dari tabel produk dan kategori
$query = "SELECT produk.namaProduk, produk.image, produk.harga, produk.stok, kategori.nama_kategori 
FROM produk 
INNER JOIN kategori ON produk.kategori_id = kategori.kategori_id";

// Eksekusi query
$exec = mysqli_query($conn, $query);

// Perulangan untuk menampilkan setiap baris hasil query
while ($post = mysqli_fetch_assoc($exec)) :
  ?>
  <tr>
    <td><?= $index++; ?></td>
    <td><?= $post['namaProduk']; ?></td>
    <td><?= $post['harga']; ?></td>
    <td><?= $post['stok']; ?></td>
    <td><?= $post['nama_kategori']; ?></td>
    <td>
      <div class="dropdown">
<!-- Tombol dropdown untuk Pilihan -->
 <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
  <i class="bx bx-dots-vertical-rounded"></i>
</button>
<!-- Menu dropdown -->
 <div class="dropdown-menu">
<!-- Pilihan Edit -->
<a href="edit_produk.php?produk_id=<?= $post['id_produk']; ?>" class="dropdown-item">
<i class="bx bx-edit-alt me-2"></i> Edit </a>
<!-- Pilihan Delete -->
 <a href="#" class="dropdown-item" data-bs-toggle="modal"
 data-bs-target="#deleteProduk_<?= $post['id_produk']; ?>">
 <i class="bx bx-trash me-2"></i> Delete </a>
</div>
</div>
</td>
</tr>
<!-- Modal untuk Hapus konten Blog -->
 <div class="modal fade" id="deleteProduk_<?= $post['id_produk']; ?>" tabinex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Hapus Produk?</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
  <form action="proses_post.php" method="POST">
    <div>
      <p>Tindakan ini tidak bisa dibatalkan.</p>
      <input type="hidden" name="produkID" value="<?= $post['id_produk']; ?>">
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-outline-secondary" dara-bs-dismiss="modal">Batal</button>
  <button type="submit" name="delete" class="btn btn-primary">Hapus</button>
</div>
</form>
</div>
</div>
</div>
</div>
<?php endwhile; ?>
</tbody>
</table>
</div>
</div>
</div>
<!-- Akhir tabel dengan baris yang dapat di-hover -->
</div>
</div>

<?php
include (".includes/footer.php");
?>
