<style>
  .navbar-main {
    background-color: #ffffff;
    border-bottom: 1px solid #e0e0e0;
    padding: 0.75rem 0;
  }

  .navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
  }

  .navbar-brand-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    z-index: 2;
  }

  .navbar-brand-custom img {
    height: 50px;
    width: auto;
    object-fit: contain;
  }

  .brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
    font-weight: 700;
  }

  .brand-system {
    font-size: 0.75rem;
    color: #333;
    margin-top: 0.25rem;
  }

  /* Center menu on desktop */
  .nav-center {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
  }

  .nav-menu-custom {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
  }

  .nav-right {
    z-index: 2;
  }

  .nav-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 2px solid transparent;
    background-color: transparent;
    color: #333;
    white-space: nowrap;
  }

  .nav-btn:hover {
    background-color: #e3f2fd;
    color: #0066cc;
  }

  .nav-btn.active {
    background-color: #e3f2fd;
    border-color: #2196f3;
    color: #0066cc;
  }

  .nav-btn i {
    font-size: 1rem;
  }

  .nav-btn-login {
    background-color: #357CA5;
    color: white;
    border-color: #357CA5;
  }

  .nav-btn-login:hover {
    background-color: #2D6A8F;
    border-color: #2D6A8F;
    color: white;
  }

  .nav-btn-user {
    background-color: transparent;
    color: #333;
    border: none;
  }

  .nav-btn-user:hover {
    background-color: #f5f5f5;
    color: #333;
  }

  /* Responsive styles */
  @media (max-width: 991.98px) {
    .navbar-container {
      flex-wrap: wrap;
    }

    .nav-center {
      position: static;
      transform: none;
      width: 100%;
      order: 3;
    }

    .nav-menu-custom {
      flex-direction: column;
      align-items: stretch;
      gap: 0.25rem;
      padding: 1rem 0;
    }

    .nav-btn {
      justify-content: flex-start;
      padding: 0.75rem 1rem;
    }

    .nav-right {
      display: none;
    }

    .nav-right-mobile {
      display: block !important;
    }

    .dropdown-menu {
      position: static !important;
      border: none;
      box-shadow: none;
      padding-left: 1rem;
    }
  }

  @media (min-width: 992px) {
    .nav-right-mobile {
      display: none !important;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-main">
  <div class="container navbar-container">
    <!-- Brand (Left) -->
    <a class="navbar-brand-custom" href="<?php echo BASE_URL; ?>">
      <div class="brand-text">
        <img src="<?php echo BASE_URL; ?>logo_unikom.png" alt="Logo UNIKOM" class="img-fluid ">
        <span class="brand-system">Visualisasi Data Jurnal Penelitian</span>
      </div>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Center Navigation Menu -->
    <div class="collapse navbar-collapse nav-center" id="navbarNav">
      <ul class="nav-menu-custom">
        <li>
          <a class="nav-btn <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>dashboard">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            Dashboard
          </a>
        </li>
        <li>
          <a class="nav-btn <?php echo ($currentPage ?? '') === 'penelitian' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>penelitian">
            <i class="bi bi-journal-text"></i>
            Penelitian Dosen
          </a>
        </li>
        <!-- Login/User for Mobile -->
        <?php if (isset($user) && $user): ?>
          <li class="nav-item dropdown nav-right-mobile">
            <a class="nav-btn nav-btn-user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle"></i>
              <?php echo htmlspecialchars($user->full_name); ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <form action="<?php echo BASE_URL; ?>auth/logout" method="POST">
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-right-mobile">
            <a class="nav-btn nav-btn-login" href="<?php echo BASE_URL; ?>auth/login">
              <i class="bi bi-box-arrow-in-right"></i>
              Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Right Side Login (Desktop Only) -->
    <div class="nav-right">
      <?php if (isset($user) && $user): ?>
        <div class="dropdown">
          <a class="nav-btn nav-btn-user dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
            <?php echo htmlspecialchars($user->full_name); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <form action="<?php echo BASE_URL; ?>auth/logout" method="POST">
                <button type="submit" class="dropdown-item text-danger">
                  <i class="bi bi-box-arrow-right me-2"></i>Logout
                </button>
              </form>
            </li>
          </ul>
        </div>
      <?php else: ?>
        <a class="nav-btn nav-btn-login" href="<?php echo BASE_URL; ?>auth/login">
          <i class="bi bi-box-arrow-in-right"></i>
          Login
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>