<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?php echo BASE_URL; ?>">
      <i class="bi bi-mortarboard me-2"></i>KP Penelitian Dosen
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>dashboard">
            <i class="bi bi-speedometer2 me-1"></i>Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($currentPage ?? '') === 'user' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>user">
            <i class="bi bi-people me-1"></i>Users
          </a>
        </li>
      </ul>
      <ul class="navbar-nav align-items-center">
        <?php if (isset($user) && $user): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown">
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
            <a class="btn btn-outline-light btn-sm" href="<?php echo BASE_URL; ?>auth/login">
              <i class="bi bi-box-arrow-in-right me-1"></i>Login
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
