<?php
session_start();
require_once("../config.php");

// Cek apakah form dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil dan sanitasi input email dan password
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // Ambil data pengguna dari database berdasarkan email
    $sql = "SELECT * FROM pelanggan WHERE email = '$email'";
    $result = $conn->query($sql);

    // Periksa apakah pengguna ditemukan
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        $validPassword = false;
        if ($row["role"] === "admin") {
            // Admin: password disimpan tanpa hash (plain text)
            $validPassword = ($password === $row["password"]);
        } else {
            // Pelanggan: password diverifikasi menggunakan hashing
            $validPassword = password_verify($password, $row["password"]);
        }

        if ($validPassword) {
            // Set session pengguna setelah login berhasil
            $_SESSION["email"] = $row["email"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["user_id"] = $row["id"]; // Asumsi kolom 'id' adalah primary key

            // Set notifikasi selamat datang
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];

            // Redirect ke dashboard sesuai role
            if ($row["role"] === "admin") {
                header("Location: ../dashboard_admin.php");
            } else {
                header("Location: ../dashboard_pelanggan.php");
            }
            exit();
        } else {
            // Password salah
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Email atau Password salah'
            ];
        }
    } else {
        // Email tidak ditemukan di database
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Email atau Password salah'
        ];
    }

    // Redirect kembali ke halaman login jika login gagal
    header("Location: login.php");
    exit();
}

// Tutup koneksi database
$conn->close();
?>