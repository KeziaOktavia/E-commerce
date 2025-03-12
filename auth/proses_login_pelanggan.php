<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM pelanggan WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        //Verifikasi password
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["email"] = $row["email"];
            $_SESSION["alamat"] = $row["alamat"];
            $_SESSION["pelanggan_id"] = $row["pelanggan_id"];
            // set notifikasi selamat datang
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];
            // Redirect ke dashboard
            header('Location: ../dashboard_pelanggan.php');
            exit();
        
        } else {
            // Password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Username atau Password salah'
            ];
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Username atau Password salah'
        ];
    }
    // Redirest kembali ke halaman login jika gagal
    header('Location: login.php');
    exit();
}
$conn->close();
?>