<?php
// Menyertakan header halaman 
include '.includes/header_admin.php';
?>
<div class="container-xxl flex-grow-1 container-p-y">
<!-- Judul halaman -->
 <div class="row">
<!-- Form untuk menambahkan postingan baru -->
 <div class="col-md-10">
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="proses_post.php"
            enctype="multipart/form-data">

            <!-- Input untuk mengunggah gambar -->
 <div class="mb-3">
    <label for="formFile" class="form-label">Unggah Gambar</label>
    <input class="form-control" type="file" name="image" accept="image/*" />
</div>
<!-- Input untuk Nama Produk -->
 <div class="mb-3">
    <label for="namaProduk" class="form-label">Nama Produk</label>
    <input type="text"  class="form-control"name="namaProduk" required>
</div>

<!-- Input untuk Harga Produk -->
<div class="mb-3">
    <label for="harga" class="form-label">Harga Satuan</label>
    <input type="text"  class="form-control"name="harga" required>
</div>

<!-- Input untuk Stok Produk -->
<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number"  class="form-control"name="stok" required>
</div>

<!-- Dropdown untuk memilih kategori -->
<div class="mb-3">
    <label for="kategori_id" class="form-label">Kategori</label>
    <select class="form-select" name="kategori_id" required>
<!-- Mengambil data kategori dari database untuk mengisi opsi dropdown -->
<option value="" selected disabled>Pilih salah satu</option>

 <?php
 $query = "SELECT * FROM kategori"; // Query untuk mengambil data kategori
 $result = $conn->query($query); // Menjalankan query 
 if ($result->num_rows > 0) { // Jika terdapat data kategori 
    while ($row = $result->fetch_assoc()) { // Iterasi setiap kategori
        echo "<option value='" . $row["kategori_id"] ."'>". $row["nama_kategori"] . "</option>";
    }
 }
?>
</select>
</div>
<!-- Textarea untuk deskripsi Produk -->


<!-- Tombol submit -->
 <button type="submit" name="simpan" class="btn btn-primary">Posting Produk</button>
</form>
</div>
</div>
</div>
</div>
</div>
<?
// Menyertakan footer halaman
include '.includes/footer.php';
?>php