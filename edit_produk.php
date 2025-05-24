<?php
// Memasukkan file konfigurasi database
include 'config.php';

// Memasukkan header halaman
include '.includes/header_admin.php';

// Mengecek apakah produk_id ada di URL
if (!isset($_GET['produk_id']) || empty($_GET['produk_id'])) {
    // Jika tidak ada produk_id di URL, tampilkan pesan error
    echo "ID produk tidak ditemukan.";
    exit();
}

// Mengambil ID produk yang akan diedit dari parameter URL
$produkIdToEdit = $_GET['produk_id']; // Pastikan parameter 'produk_id' ada di URL

// Query untuk mengambil data produk berdasarkan ID
$query = "SELECT * FROM produk WHERE produk_id = $produkIdToEdit";
$result = $conn->query($query);

// Memeriksa apakah data produk ditemukan
if ($result->num_rows > 0) {
    $produk = $result->fetch_assoc(); // Mengambil data produk ke dalam array
} else {
    // Menampilkan pesan jika produk tidak ditemukan
    echo "Produk tidak ditemukan.";
    exit(); // Menghentikan eksekusi jika tidak ada produk
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- Form untuk mengedit produk -->
        <div class="col-md-10">
            <div class="card mb-4">
                <div class="card-body">
                    <!-- Formulir menggunakan metode POST untuk mengirim data -->
                    <form method="POST" action="proses_post.php" enctype="multipart/form-data">
                        <!-- Input tersembunyi untuk menyimpan ID produk -->
                        <input type="hidden" name="produk_id" value="<?php echo $produkIdToEdit; ?>">

                        <!-- Input untuk Nama Produk-->
                        <div class="mb-3">
                            <label for="namaProduk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="namaProduk" name="namaProduk" value="<?php echo $produk['namaProduk']; ?>" required>
                        </div>

                        <!-- Input untuk Harga Produk -->
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Satuan</label>
                            <input type="text" class="form-control" name="harga" value="<?php echo $produk['harga']; ?>" required>
                        </div>

                        <!-- Input untuk Stok Produk -->
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" value="<?php echo $produk['stok']; ?>" required>
                        </div>

                        <!-- Input untuk unggah gambar -->
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Unggah Gambar</label>
                            <input class="form-control" type="file" id="formFile" name="image_path" accept="image/*">
                            <?php if (!empty($produk['image_path'])): ?>
                                <!-- Menampilkan gambar yang sudah diunggah -->
                                <div class="mt-2">
                                    <img src="<?= $produk['image_path']; ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Dropdown untuk memilih kategori -->
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select class="form-select" name="kategori_id" required>
                                <option value="" selected disabled>Pilih kategori</option>
                                <?php
                                // Mengambil data kategori dari database
                                $queryKategori = "SELECT * FROM kategori";
                                $resultKategori = $conn->query($queryKategori);

                                // Menambahkan opsi ke dropdown
                                if ($resultKategori->num_rows > 0) {
                                    while ($row = $resultKategori->fetch_assoc()) {
                                        // Menandai kategori yang sudah dipilih
                                        $selected = ($row["kategori_id"] == $produk['kategori_id']) ? "selected" : "";
                                        echo "<option value='" . $row["kategori_id"] . "' $selected>" . $row["nama_kategori"] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tombol untuk memperbarui produk -->
                        <button type="submit" name="update" class="btn btn-primary">Update Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Menyertakan footer halaman
include '.includes/footer.php';
?>
