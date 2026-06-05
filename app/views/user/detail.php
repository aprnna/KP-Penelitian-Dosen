<!-- Page-specific styles for consistent design -->
<style>
  :root {
    --page-primary: #0066cc;
    --page-primary-hover: #0056b3;
    --page-primary-light: #e6f2ff;
    --page-success: #16a34a;
    --page-success-light: #dcfce7;
    --page-muted: #64748b;
    --page-border: #e2e8f0;
    --page-card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
    --page-radius: 12px;
    --page-radius-sm: 8px;
  }

  .page-container {
    max-width: 800px;
    padding: 1.5rem;
    margin: 0 auto;
  }

  .page-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: var(--page-radius-sm);
    border: 1px solid var(--page-border);
    background: #ffffff;
    color: #475569;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    margin-bottom: 1.5rem;
  }

  .page-back-btn:hover {
    background: var(--page-primary-light);
    border-color: var(--page-primary);
    color: var(--page-primary);
  }

  /* Profile Card */
  .profile-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    overflow: hidden;
  }

  .profile-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--page-border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8fafc;
  }

  .profile-card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .profile-card-title i {
    color: var(--page-primary);
  }

  .profile-card-body {
    padding: 1.5rem;
  }

  /* Profile Avatar */
  .profile-avatar-section {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--page-border);
  }

  .profile-avatar {
    width: 80px;
    height: 80px;
    border-radius: 16px;
    background: linear-gradient(135deg, #0066cc 0%, #004499 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .profile-avatar i {
    font-size: 2.5rem;
    color: #ffffff;
  }

  .profile-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
  }

  .profile-email {
    font-size: 0.875rem;
    color: var(--page-muted);
    display: flex;
    align-items: center;
    gap: 0.375rem;
  }

  /* Info Table */
  .info-table {
    width: 100%;
  }

  .info-table tr {
    border-bottom: 1px solid var(--page-border);
  }

  .info-table tr:last-child {
    border-bottom: none;
  }

  .info-table th {
    padding: 0.875rem 0;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--page-muted);
    text-align: left;
    width: 140px;
    vertical-align: top;
  }

  .info-table td {
    padding: 0.875rem 0;
    font-size: 0.9375rem;
    color: #1e293b;
  }

  .info-value {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .info-value i {
    color: var(--page-primary);
    font-size: 0.875rem;
  }

  /* Responsive */
  @media (max-width: 575.98px) {
    .profile-avatar-section {
      flex-direction: column;
      text-align: center;
    }

    .profile-email {
      justify-content: center;
    }

    .info-table th {
      width: 100px;
    }
  }
</style>

<div class="page-container">
  <a href="<?php echo BASE_URL; ?>user" class="page-back-btn">
    <i class="bi bi-arrow-left"></i>
    Kembali
  </a>

  <div class="profile-card">
    <div class="profile-card-header">
      <h4 class="profile-card-title">
        <i class="bi bi-person"></i>
        User Detail
      </h4>
    </div>
    <div class="profile-card-body">
      <!-- Avatar Section -->
      <div class="profile-avatar-section">
        <div class="profile-avatar">
          <i class="bi bi-person-fill"></i>
        </div>
        <div>
          <div class="profile-name"><?php echo htmlspecialchars($detailUser->name ?? $detailUser->full_name ?? '-'); ?></div>
          <div class="profile-email">
            <i class="bi bi-envelope"></i>
            <?php echo htmlspecialchars($detailUser->email); ?>
          </div>
        </div>
      </div>

      <!-- Info Table -->
      <table class="info-table">
        <tr>
          <th>ID</th>
          <td>
            <span class="info-value">
              <i class="bi bi-hash"></i>
              <?php echo htmlspecialchars($detailUser->id); ?>
            </span>
          </td>
        </tr>
        <tr>
          <th>Nama</th>
          <td><?php echo htmlspecialchars($detailUser->name ?? $detailUser->full_name ?? '-'); ?></td>
        </tr>
        <tr>
          <th>Email</th>
          <td><?php echo htmlspecialchars($detailUser->email); ?></td>
        </tr>
        <tr>
          <th>Username</th>
          <td>
            <span class="info-value">
              <i class="bi bi-at"></i>
              <?php echo htmlspecialchars($detailUser->username ?? '-'); ?>
            </span>
          </td>
        </tr>
      </table>
    </div>
  </div>
</div>