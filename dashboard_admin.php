<?php
session_start();
include(".includes/header_admin.php");
$title = "Dashboard_admin";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
  // Redirect kalau bukan admin
  header("Location: login.php");
  exit();
}

include(".includes/toast_notification.php");
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <!-- Card untuk menampilkan tabel produk -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4>Semua Produk</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
        <table id="datatable" class="table table-hover">
          <thead>
            <tr class="text-center">
              <th width="50px">#</th>
              <th>Gambar</th>
              <th>Nama Produk</th>
              <th>Harga</th>
              <th>Kategori</th>
              <th>Stok</th>
              <th width="150px">Pilihan</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php
            require_once("config.php");

            $index = 1;
            $query = "SELECT produk.produk_id, produk.image_path, produk.namaProduk, produk.harga, kategori.nama_kategori, produk.stok
                      FROM produk 
                      LEFT JOIN kategori ON produk.kategori_id = kategori.kategori_id";
            $exec = mysqli_query($conn, $query);

            while ($post = mysqli_fetch_assoc($exec)) :
            ?>
              <tr class="text-center">
                <td><?= $index++; ?></td>
                <td>
                  <?php if (!empty($post['image_path']) && file_exists($post['image_path'])): ?>
                    <img src="<?= $post['image_path']; ?>" width="60" height="60" style="object-fit:cover; border-radius:8px;">
                  <?php else: ?>
                    <span class="text-muted">Tidak ada gambar</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($post['namaProduk']); ?></td>
                <td>Rp<?= number_format($post['harga'], 0, ',', '.'); ?></td>
                <td><?= htmlspecialchars($post['nama_kategori']); ?></td>
                <td><?= (int) $post['stok']; ?></td>
                <td>
                  <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                      <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                      <a href="edit_produk.php?post_id=<?= $post['produk_id']; ?>" class="dropdown-item">
                        <i class="bx bx-edit-alt me-2"></i> Edit
                      </a>
                      <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteProduk_<?= $post['produk_id']; ?>">
                        <i class="bx bx-trash me-2"></i> Hapus
                      </a>
                    </div>
                  </div>
                </td>
              </tr>

              <!-- Modal Hapus Produk -->
              <div class="modal fade" id="deleteProduk_<?= $post['produk_id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Hapus Produk <?= htmlspecialchars($post['namaProduk']); ?>?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                      <form action="proses_post.php" method="POST">
                        <p>Tindakan ini tidak bisa dibatalkan.</p>
                        <input type="hidden" name="produkID" value="<?= $post['produk_id']; ?>">
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" name="delete" class="btn btn-danger">Hapus</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include(".includes/footer.php"); ?>
