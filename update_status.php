<?php
session_start();
// Menghubungkan file config.php yang berisi koneksi database ($conn)
require_once("config.php");

// Cek apakah data 'pesanan_id' dan 'status' sudah dikirim via method POST
if (isset($_POST['pesanan_id'], $_POST['status'])) {
        // Ambil data pesanan_id dari POST dan konversi ke integer agar aman
    $pesanan_id = (int) $_POST['pesanan_id'];
        // Ambil data status dari POST dan bersihkan dari karakter berbahaya agar aman untuk query SQL
    $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Daftar status yang diperbolehkan untuk update (validasi)
    $allowed_statuses = ['Menunggu', 'Diproses', 'Dikirim', 'Selesai'];
        // Cek apakah status yang dikirim termasuk dalam daftar yang diizinkan
    if (!in_array($status, $allowed_statuses)) {
        // Jika tidak valid, simpan notifikasi error ke session
        $_SESSION['notification'] = [
            'type' => 'danger', // Jenis notifikasi untuk kegagalan
            'message' => 'Status tidak valid.'
        ];
        header("Location: detail_pemesanan_admin.php");
        exit;  // Hentikan eksekusi setelah redirect
    }

    // Query update status pesanan berdasarkan pesanan_id
    $query = "UPDATE pesanan SET status = '$status' WHERE pesanan_id = $pesanan_id";
    // Jalankan query update ke database
    if (mysqli_query($conn, $query)) {
    // Jika berhasil update, simpan notifikasi sukses ke session
        $_SESSION['notification'] = [
            'type' => 'primary', // Jenis notifikasi untuk keberhasilan
            'message' => '✅ Status berhasil diperbarui.'
        ];
    } else {
        // Jika gagal update, simpan notifikasi error beserta pesan error dari database
        $_SESSION['notification'] = [
            'type' => 'danger', // Jenis notifikasi untuk kegagalan
            'message' => '❌ Gagal memperbarui status: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman detail pesanan admin setelah update selesai
    header("Location: detail_pemesanan_admin.php");
    exit();
}
