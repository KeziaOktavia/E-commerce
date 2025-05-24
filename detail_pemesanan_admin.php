<?php
session_start();

include '.includes/header_admin.php';

// Memasukkan file toast notification (notifikasi popup kecil)
include '.includes/toast_notification.php';
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Pesanan yang belum selesai -->
    <div class="card-body">
        <div class="table-responsive">
            <!-- Tabel pesanan -->
            <table class="table table-bordered table-hover align-middle text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <!-- Judul tabel 9 kolom -->
                        <th colspan="9" class="text-dark fs-4">Semua Pesanan Pelanggan</th>
                    </tr>
                    <tr>
                         <!-- Header kolom -->
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Total</th>
                        <th>Jumlah</th>
                        <th>Alamat</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Nomor urut baris dimulai dari 1
                    $index = 1;
                    // Query ambil pesanan yang belum selesai
                    $query = "
                        SELECT pesanan.pesanan_id, produk.image_path, produk.namaProduk, produk.harga, 
                               pesanan.jumlah, pesanan.total, pelanggan.alamat, pelanggan.nama, pesanan.status
                        FROM pesanan
                        LEFT JOIN produk ON pesanan.produk_id = produk.produk_id
                        LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.pelanggan_id
                        WHERE pesanan.status != 'Selesai'";

                    // Eksekusi query ke database
                    $exec = mysqli_query($conn, $query);

                    while ($pesanan = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                              <!-- Tampilkan nomor urut -->
                            <td><?= $index++; ?></td>
                            <td>
                                 <!-- Tampilkan gambar jika ada -->
                                <?php if (!empty($pesanan['image_path']) && file_exists($pesanan['image_path'])): ?>
                                    <img src="<?= $pesanan['image_path']; ?>" width="60" height="60" class="rounded" style="object-fit:cover;">
                                <?php else: ?>
                                     <!-- Jika tidak ada gambar -->
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <!-- Nama produk -->
                            <td><?= htmlspecialchars($pesanan['namaProduk']); ?></td>
                            <!-- total harga -->
                            <td>Rp<?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <!-- Jumlah produk -->
                            <td><?= $pesanan['jumlah']; ?></td>
                            <!-- Alamat pelanggan -->
                            <td><?= htmlspecialchars($pesanan['alamat']); ?></td>
                            <!-- Nama pelanggan -->
                            <td><?= htmlspecialchars($pesanan['nama']); ?></td>
                            <!-- Status pesanan -->
                            <td><?= htmlspecialchars($pesanan['status']); ?></td>
                            <td>
                                <form method="POST" action="update_status.php">
                                    <input type="hidden" name="pesanan_id" value="<?= $pesanan['pesanan_id']; ?>">
                                    <select name="status" class="form-select form-select-sm" required>
                                        <option value="Menunggu" <?= $pesanan['status'] == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                        <option value="Diproses" <?= $pesanan['status'] == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="Dikirim" <?= $pesanan['status'] == 'Dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                        <option value="Selesai" <?= $pesanan['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pesanan yang sudah selesai -->
    <div class="card-body mt-4">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center bg-white">
                <thead class="table-light">
                    <tr>
                        <!-- Judul tabel 8 -->
                        <th colspan="8" class="text-dark fs-4">Pesanan yang Sudah Selesai</th>
                    </tr>
                    <tr>
                         <!-- Header kolom tabel -->
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Total</th>
                        <th>Jumlah</th>
                        <th>Alamat</th>
                        <th>Nama</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Inisialisasi nomor urut baris
                    $index = 1;
                    // Query mengambil data pesanan dengan status "Selesai"
                    $query = "
                        SELECT pesanan.pesanan_id, produk.image_path, produk.namaProduk, produk.harga, 
                               pesanan.jumlah, pesanan.total, pelanggan.alamat, pelanggan.nama, pesanan.status
                        FROM pesanan
                        LEFT JOIN produk ON pesanan.produk_id = produk.produk_id
                        LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.pelanggan_id
                        WHERE pesanan.status = 'Selesai'";
                         // Eksekusi query ke database
                    $exec = mysqli_query($conn, $query);

                     // Loop setiap data pesanan yang sudah selesai
                    while ($pesanan = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                            <!-- Nomor urut baris -->
                            <td><?= $index++; ?></td>
                            <td>
                                <!-- Jika image_path tidak kosong dan file gambar ada, tampilkan gambar -->
                                <?php if (!empty($pesanan['image_path']) && file_exists($pesanan['image_path'])): ?>
                                    <img src="<?= $pesanan['image_path']; ?>" width="60" height="60" class="rounded" style="object-fit:cover;">
                                <?php else: ?>
                                    <!-- Jika tidak ada gambar, tampilkan teks -->
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($pesanan['namaProduk']); ?></td>
                            <td>Rp<?= number_format($pesanan['total'], 0, ',', '.'); ?></td>
                            <td><?= $pesanan['jumlah']; ?></td>
                            <td><?= htmlspecialchars($pesanan['alamat']); ?></td>
                            <td><?= htmlspecialchars($pesanan['nama']); ?></td>
                            <td><?= htmlspecialchars($pesanan['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Sertakan file footer penutup dan script -->
<?php include(".includes/footer.php"); 
?>
