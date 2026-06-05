<h2 class="text-center mb-4 fw-bold text-dark">Register</h2>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['error'];
    unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<form action="<?php echo BASE_URL; ?>auth/register" method="POST">
  <?php echo csrf_field(); ?>
  <div class="mb-3">
    <label for="full_name" class="form-label fw-medium">Nama Lengkap</label>
    <input type="text" class="form-control" id="full_name" name="full_name" required>
  </div>

  <div class="mb-3">
    <label for="username" class="form-label fw-medium">Username</label>
    <input type="text" class="form-control" id="username" name="username" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label fw-medium">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label fw-medium">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>

  <div class="mb-3">
    <label for="confirm_password" class="form-label fw-medium">Konfirmasi Password</label>
    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
  </div>

  <button type="submit" class="btn btn-success w-100 py-2 mt-2">Daftar</button>
</form>

<div class="text-center mt-4">
  <small>Sudah punya akun? <a href="<?php echo BASE_URL; ?>auth/login" class="text-success text-decoration-none">Login disini</a></small>
</div>