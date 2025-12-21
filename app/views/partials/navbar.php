<style>
  .navbar-main {
    background-color: #ffffff;
    border-bottom: 1px solid #e0e0e0;
    padding: 0.75rem 0;
  }

  .navbar-brand-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
  }

  .navbar-brand-custom img {
    height: 50px;
    width: auto;
  }

  .brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
  }

  .brand-title {
    font-weight: bold;
    font-size: 1rem;
    color: #0066cc;
  }

  .brand-subtitle {
    font-size: 0.7rem;
    color: #666;
    font-weight: 500;
    letter-spacing: 0.5px;
  }

  .brand-system {
    font-size: 0.75rem;
    color: #333;
    margin-top: 0.25rem;
  }

  .nav-menu-custom {
    display: flex;
    gap: 0.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
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
</style>

<nav class="navbar navbar-expand-lg navbar-main">
  <div class="container">
    <!-- Brand -->
    <a class="navbar-brand-custom" href="<?php echo BASE_URL; ?>">
      <div class="brand-text">
        <img src="<?php echo BASE_URL; ?>logo_unikom.png" alt="Logo UNIKOM">
        <span class="brand-system">Visualisasi Penelitian</span>
      </div>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="nav-menu-custom">
        <li>
          <a class="nav-btn <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>dashboard">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            Dashboard
          </a>
        </li>
        <li>
          <a class="nav-btn <?php echo ($currentPage ?? '') === 'penelitian' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>penelitian">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            Penelitian Dosen
          </a>
        </li>
        <li>
          <a class="nav-btn <?php echo ($currentPage ?? '') === 'index-penelitian' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>index-penelitian">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            Index Penelitian
          </a>
        </li>
      </ul>
    </div>

    <!-- User Menu -->
    <ul class="navbar-nav align-items-center ms-auto">
      <?php if (isset($user) && $user): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle me-1"></i>
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
        <li class="nav-item">
          <a class="btn btn-primary btn-sm" href="<?php echo BASE_URL; ?>auth/login">
            <i class="bi bi-box-arrow-in-right me-1"></i>Login
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>