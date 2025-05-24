<?php
include 'config.php';
session_start();

// Cek apakah tombol submit dengan nama 'simpan' sudah ditekan (form disubmit)
if (isset($_POST['simpan'])) {
    // Ambil data yang dikirim dari form POST
    $namaProduk = $_POST['namaProduk'];
    $harga = $_POST['harga'];
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];

    // folder tujuan penyimpanan gambar yang diupload
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"];
    // Gabungkan path folder dan nama file menjadi path lengkap gambar
    $imagePath = $imageDir . basename($imageName);

// Simpan file gambar dari tempat sementara ke folder 'assets/img/uploads/'
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
       // Jika upload gambar berhasil, buat query insert data produk ke database
        $query = "INSERT INTO produk (image_path, namaproduk, harga, kategori_id, stok)
          VALUES ('$imagePath', '$namaProduk', '$harga', '$kategori_id', '$stok')";

        if ($conn->query($query) === TRUE) {
            $_SESSION['notification'] = [
                'type' => 'primary',
                'message' => 'Produk berhasil ditambahkan.'
            ];
        } else {
            $_SESSION['notification'] = [
                'type' => 'danger',
                'message' => 'Gagal menambahkan produk: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal mengunggah gambar produk.'
        ];
    }

    header("Location: dashboard_admin.php");
    exit();
}

// Proses penghapusan postingan
if (isset($_POST['delete'])) {
    // Mengambil ID post dari parameter URL
    $produk_id = $_POST['produk_id'];

    // Query untuk menghapus post produk berdasarkan ID
    $exec = mysqli_query($conn, "DELETE FROM produk WHERE produk_id='$produk_id'");

    // Menyimpan notifikasi keberhasilan atau kegagalan ke dalam session
    if ($exec) { 
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Post successfully deleted.'
        ];
    } else {
        $_SESSION['notification'] = [
            'type' =>'danger',
            'message' => 'Error deleting post: ' . mysqli_error($conn)
        ];
    }

    // Redirect kembali ke halaman dashboard
    header('Location: dashboard_admin.php');
    exit();
}

// Menangani pembaruan data postingan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Mendapatkan data dari form
    $imageDir = "assets/img/uploads/"; // Direktori penyimpanan gambar
    $produk_id = $_POST['produk_id'];
    $namaProduk = $_POST["namaProduk"];
    $harga = $_POST["harga"];
    $stok = $_POST["stok"];
    
    // Pastikan kategori_id ada
    if (isset($_POST['kategori_id']) && !empty($_POST['kategori_id'])) {
        $kategoriId = $_POST['kategori_id'];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Kategori produk harus dipilih.'
        ];
        header('Location: edit_produk.php?produk_id=' . $produk_id); // Atau halaman yang relevan
        exit();
    }

    // Periksa apakah file gambar baru diunggah
    if (!empty($_FILES["image_path"]["name"])) {
        $imageName = $_FILES["image_path"]["name"];
        $imagePath = $imageDir . $imageName;

        // Pindahkan file baru ke direktori tujuan
        move_uploaded_file($_FILES["image_path"]["tmp_name"], $imagePath);

        // Hapus gambar lama
        $queryOldImage = "SELECT image_path FROM produk WHERE produk_id = $produk_id";
        $resultOldImage = $conn->query($queryOldImage);
        if ($resultOldImage->num_rows > 0) {
            $oldImage = $resultOldImage->fetch_assoc()['image_path'];
            if (file_exists($oldImage)) {
                unlink($oldImage); // Menghapus file lama
            }
        }
    } else {
        // Jika tidak ada file baru, gunakan gambar lama
        $imagePathQuery = "SELECT image_path FROM produk WHERE produk_id = $produk_id";
        $result = $conn->query($imagePathQuery);
        $imagePath = ($result->num_rows > 0) ? $result->fetch_assoc() ['image_path'] : null;
    }

    // Update data postingan di database
    $queryUpdate = "UPDATE produk SET image_path = '$imagePath', namaProduk = '$namaProduk', harga = '$harga', kategori_id = '$kategoriId', stok = '$stok'
                    WHERE produk_id = $produk_id";

    if ($conn->query($queryUpdate) === TRUE) {
        // Notifikasi berhasil
        $_SESSION['notification'] = [
            'type' => 'primary',
            'message' => 'Postingan berhasil diperbarui.'
        ];
    } else {
        // Notifikasi gagal
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Gagal memperbarui postingan: ' . $conn->error
        ];
    }

    // Arahkan ke halaman dashboard admin
    header('Location: dashboard_admin.php');
    exit();
}
?>
