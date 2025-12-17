<h2 class="text-center mb-4 fw-bold text-dark">Login</h2>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['error'];
    unset($_SESSION['error']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['success'];
    unset($_SESSION['success']); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<form action="<?php echo BASE_URL; ?>auth/doLogin" method="POST">
  <div class="mb-3">
    <label for="username" class="form-label fw-medium">Username atau Email</label>
    <input type="text" class="form-control" id="username" name="username" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label fw-medium">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>

  <button type="submit" class="btn btn-success w-100 py-2 mt-2">Login</button>
</form>

<div class="position-relative my-4">
  <hr>
  <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau login dengan</span>
</div>

<div class="d-grid gap-2">
  <a href="<?php echo BASE_URL; ?>auth/google/login" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2">
    <i class="bi bi-google"></i>
    Login dengan Google
  </a>
</div>

<div class="position-relative my-4">
  <hr>
  <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau sign up dengan</span>
</div>

<div class="d-grid gap-2">
  <a href="<?php echo BASE_URL; ?>auth/google/register" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2">
    <i class="bi bi-google"></i>
    Sign Up dengan Google
  </a>
</div>