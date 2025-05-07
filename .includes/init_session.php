<?php
// Periksa apakah sesi sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah kunci "name" dan "role" ada dalam sesi sebelum mengaksesnya
$name = $_SESSION["username"] ?? $_SESSION["username"] ?? null;
$role = $_SESSION["role"] ?? null;

// Ambil notifikasi jika ada, kemudian hapus dari sesi
$notification = $_SESSION['notification'] ?? null;
if ($notification) {
    unset($_SESSION['notification']);
}

// Periksa apakah sesi login sudah ada (username dan role)
if (empty($_SESSION["username"]) || empty($_SESSION["role"])) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Silahkan Login Terlebih Dahulu!'  // pesan yang ditampilkan ke pengguna
    ];
    header('Location: ./auth/login.php');
    exit(); // Penting agar kode berhenti di sini
}

// Jika sudah login, ambil alamat email pengguna (biasanya hanya untuk role 'pelanggan')
$email = $_SESSION["email"] ?? null; // hanya pelanggan
?>
