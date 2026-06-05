<!-- Navbar Styles -->
<style>
  :root {
    --nav-primary: #0066cc;
    --nav-primary-hover: #0056b3;
    --nav-primary-light: #e6f2ff;
    --nav-text: #334155;
    --nav-text-muted: #64748b;
    --nav-border: #e2e8f0;
    --nav-bg: #ffffff;
    --nav-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
  }

  .navbar-app {
    background: var(--nav-bg);
    border-bottom: 1px solid var(--nav-border);
    box-shadow: var(--nav-shadow);
    padding: 0;
    position: sticky;
    top: 0;
    z-index: 1000;
  }

  .navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0.75rem 1rem;
    gap: 1rem;
  }

  /* Brand */
  .navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    flex-shrink: 0;
  }

  .navbar-brand-logo {
    height: 44px;
    width: auto;
    object-fit: contain;
  }

  .navbar-brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
  }

  .navbar-brand-title {
    font-weight: 700;
    font-size: 0.9375rem;
    color: var(--nav-text);
  }

  .navbar-brand-subtitle {
    font-size: 0.75rem;
    color: var(--nav-text-muted);
    margin-top: 0.125rem;
  }

  /* Navigation */
  .navbar-app .navbar-nav {
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .navbar-app .navbar-nav-item {
    position: relative;
    flex-shrink: 0;
  }

  .navbar-app .navbar-nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--nav-text);
    transition: all 0.2s ease;
    border: 2px solid transparent;
    background: transparent;
    white-space: nowrap;
  }

  .navbar-app .navbar-nav-link:hover {
    background: var(--nav-primary-light);
    color: var(--nav-primary);
  }

  .navbar-app .navbar-nav-link.active {
    background: var(--nav-primary-light);
    border-color: var(--nav-primary);
    color: var(--nav-primary);
  }

  .navbar-app .navbar-nav-link i {
    font-size: 1.0625rem;
  }

  /* User Menu */
  .navbar-user {
    position: relative;
    flex-shrink: 0;
  }

  .navbar-user-toggle {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    border: none;
    background: transparent;
    color: var(--nav-text);
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .navbar-user-toggle:hover {
    background: #f1f5f9;
  }

  .navbar-user-toggle i {
    font-size: 1.25rem;
  }

  .navbar-user-toggle .user-name {
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .navbar-user-toggle .dropdown-arrow {
    font-size: 0.75rem;
    transition: transform 0.2s ease;
  }

  .navbar-user-toggle[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
  }

  .navbar-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.5rem;
    background: var(--nav-bg);
    border: 1px solid var(--nav-border);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    min-width: 180px;
    padding: 0.5rem 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s ease;
    z-index: 100;
  }

  .navbar-dropdown.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }

  .navbar-dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.625rem 1rem;
    text-decoration: none;
    color: var(--nav-text);
    font-size: 0.875rem;
    transition: background 0.15s ease;
  }

  .navbar-dropdown-item:hover {
    background: #f8fafc;
  }

  .navbar-dropdown-item.danger {
    color: #dc2626;
  }

  .navbar-dropdown-item.danger:hover {
    background: #fee2e2;
  }

  .navbar-dropdown-item i {
    font-size: 1rem;
    width: 1.25rem;
    text-align: center;
  }

  .navbar-dropdown-divider {
    height: 1px;
    background: var(--nav-border);
    margin: 0.5rem 0;
  }

  /* Login Button */
  .navbar-login {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 8px;
    background: var(--nav-primary);
    color: #ffffff;
    text-decoration: none;
    font-size: 0.9375rem;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 2px solid var(--nav-primary);
  }

  .navbar-login:hover {
    background: var(--nav-primary-hover);
    border-color: var(--nav-primary-hover);
    color: #ffffff;
  }

  .navbar-login i {
    font-size: 1rem;
  }

  /* Mobile Toggle */
  .navbar-toggle {
    display: none;
    padding: 0.5rem;
    border: none;
    background: transparent;
    color: var(--nav-text);
    font-size: 1.5rem;
    cursor: pointer;
    border-radius: 8px;
    transition: background 0.2s ease;
  }

  .navbar-toggle:hover {
    background: #f1f5f9;
  }

  /* Responsive */
  @media (max-width: 991.98px) {
    .navbar-app .navbar-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .navbar-app .navbar-nav {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--nav-bg);
      border-bottom: 1px solid var(--nav-border);
      box-shadow: var(--nav-shadow);
      flex-direction: column !important;
      padding: 0.5rem;
      gap: 0.25rem;
    }

    .navbar-app .navbar-nav.show {
      display: flex;
    }

    .navbar-app .navbar-nav-link {
      justify-content: flex-start;
      width: 100%;
    }

    .navbar-app .navbar-user {
      display: none;
    }

    .navbar-app .navbar-user-mobile {
      display: block;
      padding: 0.5rem;
      border-top: 1px solid var(--nav-border);
      margin-top: 0.5rem;
    }

    .navbar-app .navbar-dropdown {
      position: static;
      margin-top: 0;
      box-shadow: none;
      border: none;
      padding: 0 0 0 1rem;
      opacity: 1;
      visibility: visible;
      transform: none;
    }

    .navbar-app .navbar-dropdown.show {
      display: block;
    }
  }

  @media (min-width: 992px) {
    .navbar-user-mobile {
      display: none;
    }
  }
</style>

<nav class="navbar-app">
  <div class="navbar-container">
    <!-- Brand -->
    <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
      <img src="<?php echo BASE_URL; ?>logo_unikom.png" alt="Logo UNIKOM" class="navbar-brand-logo">
      <div class="navbar-brand-text">
        <span class="navbar-brand-title">UNIKOM</span>
        <span class="navbar-brand-subtitle">Visualisasi Jurnal Penelitian</span>
      </div>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggle" type="button" aria-label="Toggle navigation" onclick="toggleMobileNav()">
      <i class="bi bi-list"></i>
    </button>

    <!-- Navigation -->
    <ul class="navbar-nav" id="navbarNav">
      <li class="navbar-nav-item">
        <a class="navbar-nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>dashboard">
          <i class="bi bi-grid-3x3-gap-fill"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="navbar-nav-item">
        <a class="navbar-nav-link <?php echo ($currentPage ?? '') === 'penelitian' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>penelitian">
          <i class="bi bi-journal-text"></i>
          <span>Penelitian</span>
        </a>
      </li>
      <li class="navbar-nav-item">
        <a class="navbar-nav-link <?php echo ($currentPage ?? '') === 'reporting' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>reporting">
          <i class="bi bi-file-earmark-text"></i>
          <span>Reporting</span>
        </a>
      </li>
      <li class="navbar-nav-item">
        <a class="navbar-nav-link <?php echo ($currentPage ?? '') === 'scraping' ? 'active' : ''; ?>" href="<?php echo BASE_URL; ?>scraping">
          <i class="bi bi-cloud-download"></i>
          <span>Scraping</span>
        </a>
      </li>

      <!-- Mobile User Menu -->
      <?php if (isset($user) && $user): ?>
        <li class="navbar-user-mobile">
          <div style="padding: 0.5rem; border-top: 1px solid var(--nav-border); margin-top: 0.5rem;">
            <button class="navbar-user-toggle" style="width: 100%; justify-content: flex-start;" onclick="toggleMobileDropdown()">
              <i class="bi bi-person-circle"></i>
              <span class="user-name"><?php echo htmlspecialchars($user->full_name); ?></span>
              <i class="bi bi-chevron-down dropdown-arrow ms-auto"></i>
            </button>
            <div class="navbar-dropdown show" id="mobileDropdown" style="display: none;">
              <form action="<?php echo BASE_URL; ?>auth/logout" method="POST">
                <button type="submit" class="navbar-dropdown-item danger">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Logout</span>
                </button>
              </form>
            </div>
          </div>
        </li>
      <?php endif; ?>
    </ul>

    <!-- Desktop User Menu -->
    <div class="navbar-user">
      <?php if (isset($user) && $user): ?>
        <button class="navbar-user-toggle" onclick="toggleDropdown()" aria-expanded="false">
          <i class="bi bi-person-circle"></i>
          <span class="user-name"><?php echo htmlspecialchars($user->full_name); ?></span>
          <i class="bi bi-chevron-down dropdown-arrow"></i>
        </button>
        <div class="navbar-dropdown" id="userDropdown">
          <form action="<?php echo BASE_URL; ?>auth/logout" method="POST">
            <button type="submit" class="navbar-dropdown-item danger">
              <i class="bi bi-box-arrow-right"></i>
              <span>Logout</span>
            </button>
          </form>
        </div>
      <?php else: ?>
        <a class="navbar-login" href="<?php echo BASE_URL; ?>auth/login">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<script>
  // Mobile Navigation Toggle
  function toggleMobileNav() {
    const nav = document.getElementById('navbarNav');
    nav.classList.toggle('show');
  }

  // Desktop Dropdown Toggle
  function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    const button = event.currentTarget;
    const isExpanded = button.getAttribute('aria-expanded') === 'true';

    button.setAttribute('aria-expanded', !isExpanded);
    dropdown.classList.toggle('show');
  }

  // Mobile Dropdown Toggle
  function toggleMobileDropdown() {
    const dropdown = document.getElementById('mobileDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('userDropdown');
    const userToggle = document.querySelector('.navbar-user-toggle');

    if (dropdown && !dropdown.contains(e.target) && !userToggle.contains(e.target)) {
      dropdown.classList.remove('show');
      userToggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Close mobile nav when clicking a link
  document.querySelectorAll('.navbar-nav-link').forEach(link => {
    link.addEventListener('click', function() {
      const nav = document.getElementById('navbarNav');
      if (window.innerWidth < 992) {
        nav.classList.remove('show');
      }
    });
  });
</script>