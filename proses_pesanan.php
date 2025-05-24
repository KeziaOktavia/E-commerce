<?php
session_start();
require_once("config.php");

// Cek apakah user sudah login dan memiliki role pelanggan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: login.php");
    exit();
}

// Pastikan form dikirimkan via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form, dan pastikan berupa angka (integer)
    $produk_id = intval($_POST['produk_id']);
    $jumlah = intval($_POST['jumlah']);
    $total = intval($_POST['total']);
    // Ambil ID pelanggan dari session (user yang sedang login)
    $pelanggan_id = $_SESSION['pelanggan_id']; 
    // Simpan tanggal hari ini
    $tanggal_pesanan = date('Y-m-d');

    // Ambil stok produk saat ini
    $result = mysqli_query($conn, "SELECT stok FROM produk WHERE produk_id = $produk_id");
    $produk = mysqli_fetch_assoc($result);

    // Cek apkah stok cukup untuk jumlah yang dipesan
    if (!$produk || $produk['stok'] < $jumlah) {
        // Kalau stok kurang, simpan pesan error di session dan redirect ke halaman produk
        $_SESSION['error'] = "Stok tidak mencukupi.";
        header("Location: produk_pelanggan.php");
        exit();
    }

    // Kurangi stok produk dengan jumlah yang dipesan
    $new_stok = $produk['stok'] - $jumlah;
    $update_stok = mysqli_query($conn, "UPDATE produk SET stok = $new_stok WHERE produk_id = $produk_id");

    // Masukkan data pesanan baru ke tabel pesanan di database
    $insert_pesanan = mysqli_query($conn, "INSERT INTO pesanan (pelanggan_id, tgl_pesanan, total, status, jumlah, produk_id)
        VALUES ($pelanggan_id, '$tanggal_pesanan', $total, 'menunggu', $jumlah, $produk_id)");

    // Jika update stok dan insert pesanan berhasil
    if ($insert_pesanan && $update_stok) {
        $pesanan_id = mysqli_insert_id($conn); // Ambil ID pesanan baru
        // Redirect ke halaman detail pesanan agar user bisa lihat pesanan mereka
        header("Location: detail_pesanan.php?id=$pesanan_id");
        exit();
    } else {
        // Jika gagal simpan data pesanan atau update stok, beri pesan error dan redirect ke halaman produk
        $_SESSION['error'] = "Gagal memproses pesanan.";
        header("Location: produk_pelanggan.php");
        exit();
    }
}
?>
