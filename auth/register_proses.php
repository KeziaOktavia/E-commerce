<?php
require_once("../config.php");
// Mulai session
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $name = $_POST["nama"];
    $email = $_POST["email"];
    $alamat = $_POST["alamat"];
    $password = $_POST["password"];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $role = 'pelanggan';

    $sql = "INSERT INTO pelanggan (username, nama, email, alamat, password, role) VALUES ('$username','$name','$email','$alamat','$hashedPassword','$role')";
    if ($conn->query($sql) == TRUE) {
        // Simpan notifikasi ke dalam session
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Registrasi Berhasil!' 
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal Registrasi: ' . mysqli_error($conn)
        ];
    }
    header('Location: login.php');
    exit();
}

$conn->close();
?>