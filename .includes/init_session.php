<?php
session_start();
// Ambil data dari sesi
$pelangganId = $_SESSION["pelanggan_id"];
$nama = $_SESSION["nama"];
$email = $_SESSION["email"];
// Ambil notifikasi jika ada, kemudian hapus dari sesi
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}
/* Periksa apakah sesi username dan email sudah ada,
jika tidak arahkan ke halaman login */
if (empty($_SESSION["username"]) || empty($_SESSION["email"])) {
$_SESSION['notification'] = [
    'type' => 'danger',
    'message' => 'Silahkan Login Terlebih Dahulu!'
];
header('Location: ./auth/login_pelanggan.php');
exit(); // Pastikan script berhenti setelah pengalihan
}