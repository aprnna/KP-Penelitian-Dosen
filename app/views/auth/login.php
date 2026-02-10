<style>
  .google-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.75rem 1.5rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    background: white;
    color: #4285F4;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-bottom: 1.5rem;
  }

  .google-btn:hover {
    border-color: #4285F4;
    background-color: #f8f9fa;
    color: #4285F4;
  }

  .google-btn img {
    height: 24px;
    width: 24px;
  }

  .form-label-custom {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
  }

  .form-control-custom {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
  }

  .form-control-custom:focus {
    border-color: #4AADDB;
    box-shadow: 0 0 0 3px rgba(74, 173, 219, 0.1);
  }

  .forgot-password {
    color: #4AADDB;
    text-decoration: none;
    font-size: 0.9rem;
  }

  .forgot-password:hover {
    text-decoration: underline;
    color: #2D8BC2;
  }

  .btn-login {
    background: #357CA5;
    border: none;
    border-radius: 20px;
    padding: 0.575rem 1rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    width: 100%;
    transition: all 0.2s ease;
  }

  .btn-login:hover {
    background: linear-gradient(135deg, #1E3D52 0%, #152A38 100%);
    transform: translateY(-1px);
  }
</style>

<!-- Alert Messages -->
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

<!-- Google Login Button -->
<div class="text-center mb-4">
  <a href="<?php echo BASE_URL; ?>auth/google/login" class="google-btn">
    <svg width="24" height="24" viewBox="0 0 24 24">
      <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
      <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
      <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
      <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
    </svg>
    Login With Google
  </a>
</div>

<!-- Login Form -->
<form action="<?php echo BASE_URL; ?>auth/login" method="POST">
  <div class="mb-3">
    <label for="username" class="form-label form-label-custom">Username</label>
    <input type="text" class="form-control form-control-custom" id="username" name="username" placeholder="Masukkan Username" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label form-label-custom">Password</label>
    <input type="password" class="form-control form-control-custom" id="password" name="password" placeholder="Masukkan Password" required>
  </div>

  <div class="mb-4">
    <a href="<?php echo BASE_URL; ?>auth/forgot-password" class="forgot-password">Lupa password? Silahkan Reset Password</a>
  </div>

  <button type="submit" class="btn-login">Login</button>
</form>