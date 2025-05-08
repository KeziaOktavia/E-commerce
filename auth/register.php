<?php include(".layouts/header.php"); ?>
<!-- Register Card -->
<div class="card">
  <div class="card-body">
    <!-- Mulai bikin kotak form buat register -->
    <!-- Logo -->
    <div class="app-brand justify-content-center">
      <a href="index.html" class="app-brand-link gap-2">
        <span class="app-brand-logo demo"></span>
        <span class="app-brand-text demo text-uppercase fw-bolder">SHOMERCE</span>
      </a>
    </div>
    <!-- /Logo -->
     <!-- Form register, nanti datanya dikirim ke register_proses.php pakai POST -->
    <form action="register_proses.php" class="mb-3" method="POST">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label> <!-- Input buat nama lengkap -->
        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama" />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label> <!-- Input buat email -->
        <input type="email" class="form-control" name="email" placeholder="Masukkan Email" />
      </div>
      <div class="mb-3">
        <!-- Input buat username. Pakai autofocus biar langsung aktif waktu halaman kebuka -->
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" placeholder="Masukkan Username" autofocus/>
      </div>
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label> <!-- Input buat alamat rumah lengkap -->
        <input type="text" class="form-control" name="alamat" placeholder="Masukkan alamat lengkap" />
      </div>

      <!-- Input buat password. Ada ikon mata di kanan, nanti bisa dipakai buat tombol liat password -->
      <div class="mb-3 form-password-toggle">
        <label class="form-label" for="password">Password</label>
        <div class="input-group input-group-merge">
          <input type="password" class="form-control" name="password"
          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
          <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
        </div>
      </div>
      <button class="btn btn-primary d-grid w-100">Daftar</button>
    </form>
    <p class="text-center">
      <!-- Kalau user udah punya akun, bisa klik link ini buat login -->
      <span>Sudah memiliki akun?</span><a href="login.php"><span> Masuk</span></a>
    </p>
  </div>
</div>
<!-- Register Card -->
<?php include(".layouts/footer.php"); ?>