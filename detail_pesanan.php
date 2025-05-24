<?php
session_start(); // Mulai session untuk akses data user yang login

// Jika form dikirim dengan method POST dan ada data 'hapus_id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus_id'])) {
    $hapus_id = intval($_POST['hapus_id']); // Ambil ID pesanan yang mau dihapus

    require_once("config.php"); // Hubungkan ke database

    // Cek apakah status pesanan selesai
    $cek = mysqli_query($conn, "SELECT status FROM pesanan WHERE pesanan_id = $hapus_id AND pelanggan_id = {$_SESSION['pelanggan_id']}");
    $data = mysqli_fetch_assoc($cek); // Ambil data hasil cek

    // Kalau datanya ada dan statusnya "selesai", pelanggan bisa hapus pesanan
    if ($data && strtolower($data['status']) === 'selesai') {
        mysqli_query($conn, "DELETE FROM pesanan WHERE pesanan_id = $hapus_id");
    } else {
    }

    // Redirect agar halaman tidak mengulang kirim form saat di-refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

include(".includes/header_pelanggan.php");
$title = "Dashboard_pelanggan";
// Cek apakah user login sebagai pelanggan, kalau bukan diarahkan ke login
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "pelanggan") {
    header("Location: login.php");
    exit();
}

include(".includes/toast_notification.php"); // Untuk munculkan pesan notifikasi (toast)
?>

<!-- Tampilan bagian detail pesanan -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card-header d-flex justify-content-center align-items-center">
        <h4 class="mb-3 text-center">DETAIL PEMESANAN</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Total</th>
                        <th>Jumlah</th>
                        <th>Alamat</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th> <!-- Kolom untuk tombol hapus -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once("config.php"); // Koneksi database
                    $index = 1; // Nomor urut

                    // Ambil data pesanan dari pelanggan yang sedang login
                    $query = "
                        SELECT pesanan.pesanan_id, produk.produk_id, produk.image_path, produk.namaProduk, produk.harga, 
                               pesanan.jumlah, pesanan.total, pelanggan.alamat, pelanggan.nama, pesanan.status
                        FROM pesanan
                        LEFT JOIN produk ON pesanan.produk_id = produk.produk_id
                        LEFT JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.pelanggan_id
                        WHERE pesanan.pelanggan_id = {$_SESSION['pelanggan_id']}";

                    $exec = mysqli_query($conn, $query); // Eksekusi query

                    // Tampilkan data pesanan satu per satu
                    while ($pesanan = mysqli_fetch_assoc($exec)) :
                    ?>
                        <tr>
                            <td><?= $index++; ?></td>
                            <td>
                                <?php if (!empty($pesanan['image_path']) && file_exists($pesanan['image_path'])): ?>
                                    <img src="<?= $pesanan['image_path']; ?>" width="60" height="60" class="rounded" style="object-fit:cover;">
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                             <!-- menampilkan satu baris data pesanan lengkap di tabel dari produk, harga, hingga aksi yang bisa dilakukan. -->
                            <td><?= htmlspecialchars($pesanan['namaProduk']); ?></td>
                            <td>Rp<?= number_format($pesanan['harga'], 0, ',', '.'); ?></td>
                            <td><?= $pesanan['jumlah']; ?></td>
                            <td><?= htmlspecialchars($pesanan['alamat']); ?></td>
                            <td><?= htmlspecialchars($pesanan['nama']); ?></td>
                            <td><?= htmlspecialchars($pesanan['status']); ?></td>
                            <td>
                                <?php if (strtolower($pesanan['status']) === 'selesai'): ?>
                                    <!-- Form untuk hapus pesanan, hanya muncul kalau statusnya selesai -->
                                    <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?');">
                                        <input type="hidden" name="hapus_id" value="<?= $pesanan['pesanan_id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">-</span> <!-- Kalau belum selesai, tombol hapus tidak muncul -->
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
