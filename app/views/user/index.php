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
    max-width: 1400px;
    padding: 1.5rem;
    margin: 0 auto;
  }

  .page-header {
    margin-bottom: 1.5rem;
  }

  .page-header h4 {
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .page-header h4 i {
    color: var(--page-primary);
  }

  /* Data Card */
  .data-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    overflow: hidden;
  }

  .data-card-body {
    padding: 0;
  }

  /* Table */
  .data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table thead th {
    background: #f8fafc;
    padding: 0.875rem 1.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--page-muted);
    border-bottom: 1px solid var(--page-border);
    text-align: left;
  }

  .data-table thead th.center {
    text-align: center;
  }

  .data-table tbody td {
    padding: 0.875rem 1.25rem;
    font-size: 0.875rem;
    border-bottom: 1px solid var(--page-border);
    vertical-align: middle;
    color: #475569;
  }

  .data-table tbody tr:hover {
    background: #f8fafc;
  }

  .data-table tbody tr:last-child td {
    border-bottom: none;
  }

  .user-id {
    font-family: 'Fira Code', 'Consolas', monospace;
    font-size: 0.8125rem;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    color: #475569;
  }

  .user-name {
    font-weight: 500;
    color: #1e293b;
  }

  .user-email {
    color: var(--page-muted);
    font-size: 0.8125rem;
  }

  /* Action Button */
  .btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: var(--page-radius-sm);
    font-size: 0.8125rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    background: var(--page-primary-light);
    color: var(--page-primary);
    border: 1px solid transparent;
  }

  .btn-action:hover {
    background: var(--page-primary);
    color: #ffffff;
  }

  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--page-muted);
  }

  .empty-state i {
    font-size: 3rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
  }

  .empty-state p {
    font-size: 0.9375rem;
    margin: 0;
  }
</style>

<div class="page-container">
  <div class="page-header">
    <h4><i class="bi bi-people-fill"></i> User List</h4>
  </div>

  <div class="data-card">
    <div class="data-card-body">
      <?php if (!empty($users)): ?>
        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th class="center" style="width: 60px;">#</th>
                <th style="width: 80px;">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th class="center" style="width: 100px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; foreach ($users as $u): ?>
                <tr>
                  <td class="center"><?php echo $no++; ?></td>
                  <td><span class="user-id"><?php echo $u->id; ?></span></td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-person text-muted"></i>
                      <span class="user-name"><?php echo htmlspecialchars($u->name); ?></span>
                    </div>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <i class="bi bi-envelope text-muted"></i>
                      <span class="user-email"><?php echo htmlspecialchars($u->email); ?></span>
                    </div>
                  </td>
                  <td class="center">
                    <a href="<?php echo BASE_URL; ?>user/detail/<?php echo $u->id; ?>" class="btn-action">
                      <i class="bi bi-eye"></i>
                      View
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="bi bi-people"></i>
          <p>No users found.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>