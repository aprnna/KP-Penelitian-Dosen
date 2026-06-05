<!-- Page-specific styles for consistent design -->
<style>
  :root {
    --page-primary: #0066cc;
    --page-primary-hover: #0056b3;
    --page-primary-light: #e6f2ff;
    --page-success: #16a34a;
    --page-success-light: #dcfce7;
    --page-danger: #dc2626;
    --page-danger-light: #fee2e2;
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
    font-size: 1.25rem;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .page-header h4 i {
    color: var(--page-primary);
  }

  .page-header p {
    color: var(--page-muted);
    margin: 0.375rem 0 0;
    font-size: 0.875rem;
  }

  /* Filter Card */
  .filter-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
  }

  .filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
  }

  .filter-group {
    flex: 1;
    min-width: 150px;
  }

  .filter-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #475569;
    margin-bottom: 0.5rem;
  }

  .filter-input {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1px solid var(--page-border);
    border-radius: var(--page-radius-sm);
    font-size: 0.9375rem;
    color: #1e293b;
    background: #ffffff;
    transition: all 0.2s ease;
  }

  .filter-input:focus {
    outline: none;
    border-color: var(--page-primary);
    box-shadow: 0 0 0 3px var(--page-primary-light);
  }

  .filter-input::placeholder {
    color: #94a3b8;
  }

  .filter-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
  }

  /* Buttons */
  .btn-primary-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: var(--page-radius-sm);
    border: 2px solid var(--page-primary);
    background: var(--page-primary);
    color: #ffffff;
    font-size: 0.9375rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-primary-custom:hover {
    background: var(--page-primary-hover);
    border-color: var(--page-primary-hover);
    color: #ffffff;
  }

  .btn-secondary-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: var(--page-radius-sm);
    border: 1px solid var(--page-border);
    background: #ffffff;
    color: #475569;
    font-size: 0.9375rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-secondary-custom:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1e293b;
  }

  .btn-danger-custom {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: var(--page-radius-sm);
    border: 2px solid var(--page-danger);
    background: var(--page-danger);
    color: #ffffff;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .btn-danger-custom:hover {
    background: #b91c1c;
    border-color: #b91c1c;
    color: #ffffff;
  }

  /* Alert */
  .alert-error {
    background: var(--page-danger-light);
    border: 1px solid #fecaca;
    border-radius: var(--page-radius-sm);
    padding: 1rem 1.25rem;
    color: #991b1b;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
  }

  .alert-error i {
    font-size: 1.125rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
  }

  /* Results Card */
  .results-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    overflow: hidden;
  }

  .results-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--page-border);
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    background: #f8fafc;
  }

  .results-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 1rem;
  }

  .results-period {
    font-size: 0.8125rem;
    color: var(--page-muted);
    margin-top: 0.125rem;
  }

  .results-period i {
    color: var(--page-primary);
    margin-right: 0.25rem;
  }

  /* Table */
  .data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table thead th {
    background: #f8fafc;
    padding: 0.875rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--page-muted);
    border-bottom: 1px solid var(--page-border);
    text-align: left;
    white-space: nowrap;
  }

  .data-table thead th.center {
    text-align: center;
  }

  .data-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    border-bottom: 1px solid var(--page-border);
    color: #475569;
    vertical-align: middle;
  }

  .data-table tbody tr:hover {
    background: #f8fafc;
  }

  .data-table tbody tr:last-child td {
    border-bottom: none;
  }

  .cell-title {
    font-weight: 500;
    color: #1e293b;
    max-width: 300px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .cell-authors {
    max-width: 180px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .cell-link {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .cell-link a {
    color: var(--page-primary);
    text-decoration: none;
    font-size: 0.8125rem;
  }

  .cell-link a:hover {
    text-decoration: underline;
  }

  .cell-number {
    text-align: center;
    font-weight: 600;
    color: #1e293b;
  }

  .quartile-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    background: var(--page-primary-light);
    color: var(--page-primary);
  }

  .quartile-badge.q1 {
    background: #fef3c7;
    color: #92400e;
  }

  .quartile-badge.q2 {
    background: #dbeafe;
    color: #1e40af;
  }

  .quartile-badge.q3 {
    background: #dcfce7;
    color: #166534;
  }

  .quartile-badge.q4 {
    background: #f3e8ff;
    color: #7c3aed;
  }

  .source-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    background: #f1f5f9;
    color: #475569;
  }

  .source-badge i {
    font-size: 0.6875rem;
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

  /* Responsive */
  @media (max-width: 768px) {
    .filter-row {
      flex-direction: column;
    }

    .filter-group {
      width: 100%;
    }

    .filter-actions {
      width: 100%;
    }

    .filter-actions button,
    .filter-actions a {
      flex: 1;
      justify-content: center;
    }

    .results-header {
      flex-direction: column;
      align-items: flex-start;
    }

    .cell-title,
    .cell-authors {
      max-width: 100%;
    }
  }
</style>

<div class="page-container">
  <!-- Page Header -->
  <div class="page-header">
    <h4><i class="bi bi-file-earmark-text"></i> Reporting Artikel</h4>
    <p>Tentukan rentang tahun untuk melihat data artikel dan export ke PDF.</p>
  </div>

  <?php if (!empty($errorMessage)): ?>
    <div class="alert-error">
      <i class="bi bi-exclamation-circle"></i>
      <span><?php echo htmlspecialchars($errorMessage); ?></span>
    </div>
  <?php endif; ?>

  <!-- Filter Card -->
  <div class="filter-card">
    <form method="GET" action="<?php echo BASE_URL; ?>reporting" class="filter-row">
      <div class="filter-group">
        <label for="start_year">Tahun Mulai</label>
        <input
          type="number"
          class="filter-input"
          id="start_year"
          name="start_year"
          min="1900"
          max="2100"
          step="1"
          value="<?php echo htmlspecialchars($startYear ?? ''); ?>"
          placeholder="Contoh: 2020"
          required>
      </div>

      <div class="filter-group">
        <label for="end_year">Tahun Akhir</label>
        <input
          type="number"
          class="filter-input"
          id="end_year"
          name="end_year"
          min="1900"
          max="2100"
          step="1"
          value="<?php echo htmlspecialchars($endYear ?? ''); ?>"
          placeholder="Contoh: 2025"
          required>
      </div>

      <div class="filter-actions">
        <button type="submit" class="btn-primary-custom">
          <i class="bi bi-search"></i>
          <span>Tampilkan</span>
        </button>
        <a href="<?php echo BASE_URL; ?>reporting" class="btn-secondary-custom">
          <i class="bi bi-arrow-counterclockwise"></i>
          <span>Reset</span>
        </a>
      </div>
    </form>
  </div>

  <?php if (!empty($startYear) && !empty($endYear) && empty($errorMessage)): ?>
    <!-- Results Card -->
    <div class="results-card">
      <div class="results-header">
        <div>
          <div class="results-title">Hasil Reporting</div>
          <div class="results-period">
            <i class="bi bi-calendar3"></i>
            Periode: <?php echo htmlspecialchars($startYear); ?> - <?php echo htmlspecialchars($endYear); ?>
          </div>
        </div>
        <a class="btn-danger-custom" href="<?php echo BASE_URL; ?>reporting/exportPdf?start_year=<?php echo urlencode($startYear); ?>&end_year=<?php echo urlencode($endYear); ?>">
          <i class="bi bi-file-earmark-pdf"></i>
          <span>Export PDF</span>
        </a>
      </div>

      <?php if (!empty($articles)): ?>
        <div class="table-responsive">
          <table class="data-table">
            <thead>
              <tr>
                <th class="center" style="width: 50px;">#</th>
                <th>Judul Artikel</th>
                <th style="width: 180px;">Penulis</th>
                <th style="width: 100px;">DOI</th>
                <th style="width: 80px;" class="center">Quartile</th>
                <th style="width: 140px;">Link</th>
                <th style="width: 70px;" class="center">Sitasi</th>
                <th style="width: 100px;">Sumber</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($articles as $index => $article): ?>
                <tr>
                  <td class="cell-number"><?php echo (int) $index + 1; ?></td>
                  <td>
                    <div class="cell-title" title="<?php echo htmlspecialchars($article->title ?? ''); ?>">
                      <?php echo htmlspecialchars($article->title ?? '-'); ?>
                    </div>
                  </td>
                  <td>
                    <div class="cell-authors" title="<?php echo htmlspecialchars($article->authors ?? ''); ?>">
                      <?php echo htmlspecialchars($article->authors ?? '-'); ?>
                    </div>
                  </td>
                  <td>
                    <?php if (!empty($article->doi)): ?>
                      <span style="font-size: 0.8125rem; color: #475569;"><?php echo htmlspecialchars($article->doi); ?></span>
                    <?php else: ?>
                      <span style="color: #94a3b8;">-</span>
                    <?php endif; ?>
                  </td>
                  <td class="center">
                    <?php if (!empty($article->quartile)): ?>
                      <?php
                        $quartile = strtoupper($article->quartile);
                        $qClass = strtolower($quartile);
                      ?>
                      <span class="quartile-badge <?php echo $qClass; ?>"><?php echo htmlspecialchars($quartile); ?></span>
                    <?php else: ?>
                      <span style="color: #94a3b8;">-</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php $link = $article->url ?? ''; ?>
                    <?php if (!empty($link)): ?>
                      <div class="cell-link">
                        <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo htmlspecialchars($link); ?>">
                          <?php echo htmlspecialchars($link); ?>
                        </a>
                      </div>
                    <?php else: ?>
                      <span style="color: #94a3b8;">-</span>
                    <?php endif; ?>
                  </td>
                  <td class="cell-number"><?php echo htmlspecialchars((string) ($article->citation_count ?? '0')); ?></td>
                  <td>
                    <?php if (!empty($article->article_source)): ?>
                      <span class="source-badge">
                        <i class="bi bi-journal"></i>
                        <?php echo htmlspecialchars($article->article_source); ?>
                      </span>
                    <?php else: ?>
                      <span style="color: #94a3b8;">-</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="empty-state">
          <i class="bi bi-inbox"></i>
          <p>Tidak ada data pada rentang tahun tersebut.</p>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>