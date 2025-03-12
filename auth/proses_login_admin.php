<?php
session_start();
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Debugging input
    var_dump($_POST); // Menampilkan semua data yang dikirimkan dari form

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            $_SESSION["nama"] = $row["nama"];
            $_SESSION["role"] = $row["role"];
            $_SESSION["admin_id"] = $row["admin_id"];
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Selamat Datang Kembali!'
            ];
            header('Location: ../dashboard_admin.php');
            exit();
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Username atau Password salah'
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Username atau Password salah'
        ];
    }
    header('Location: login.php');
    exit();
}
$conn->close();
?>
