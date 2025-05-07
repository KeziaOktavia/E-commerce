<?php
session_start();
require_once("../config.php");

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = "SELECT * FROM pelanggan WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);

    if ($data['role'] === 'admin') {
        if ($password === $data['password']) {
            $_SESSION['email'] = $data['email'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = 'admin';
            header("Location: ../dashboard_admin.php");
            exit();
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Email atau password salah!'
            ];
            header("Location: login.php");
            exit();
        }
    } elseif ($data['role'] === 'pelanggan') {
        if (password_verify($password, $data['password'])) {
            $_SESSION['email'] = $data['email'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = 'pelanggan';
            header("Location: ../dashboard_pelanggan.php");
            exit();
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Email atau password salah!'
            ];
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Role tidak dikenali.'
        ];
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'Email atau password salah!'
    ];
    header("Location: login.php");
    exit();
}

mysqli_close($conn);
?>
