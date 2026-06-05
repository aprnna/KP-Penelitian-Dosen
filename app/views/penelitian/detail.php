<!-- Page-specific styles for consistent design -->
<style>
  /* Design System */
  :root {
    --page-primary: #0066cc;
    --page-primary-hover: #0056b3;
    --page-primary-light: #e6f2ff;
    --page-success: #16a34a;
    --page-success-light: #dcfce7;
    --page-warning: #d97706;
    --page-warning-light: #fef3c7;
    --page-muted: #64748b;
    --page-border: #e2e8f0;
    --page-card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
    --page-radius: 12px;
    --page-radius-sm: 8px;
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
    margin-bottom: 1.5rem;
  }

  .profile-card-body {
    padding: 1.5rem;
  }

  /* Profile Header */
  .profile-header {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 16px;
    background: linear-gradient(135deg, #0066cc 0%, #004499 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .profile-avatar i {
    font-size: 3rem;
    color: #ffffff;
  }

  .profile-info {
    flex: 1;
  }

  .profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .profile-verified {
    color: var(--page-success);
    font-size: 1.25rem;
  }

  .profile-meta {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
    margin-bottom: 0.75rem;
  }

  .profile-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--page-muted);
  }

  .profile-meta-item i {
    color: var(--page-primary);
    width: 16px;
  }

  .profile-tag {
    display: inline-flex;
    padding: 0.375rem 0.75rem;
    background: var(--page-primary-light);
    color: var(--page-primary);
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 500;
  }

  /* Stats Card */
  .stats-card {
    background: #f8fafc;
    border-radius: var(--page-radius-sm);
    padding: 1rem;
    height: 100%;
  }

  .stats-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
  }

  .stats-title {
    font-size: 0.8125rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
  }

  .stats-select {
    border-radius: 6px;
    border: 1px solid var(--page-border);
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    background: #ffffff;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.5rem;
  }

  .stats-item {
    background: #ffffff;
    padding: 0.75rem;
    border-radius: 6px;
    border-left: 3px solid var(--page-primary);
  }

  .stats-item.info {
    border-left-color: #0891b2;
  }

  .stats-label {
    font-size: 0.6875rem;
    color: var(--page-muted);
    margin-bottom: 0.125rem;
  }

  .stats-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--page-primary);
  }

  .stats-item.info .stats-value {
    color: #0891b2;
  }

  .stats-note {
    font-size: 0.6875rem;
    color: var(--page-muted);
    margin-top: 0.75rem;
    display: flex;
    align-items: flex-start;
    gap: 0.375rem;
  }

  .stats-note i {
    color: #94a3b8;
    margin-top: 0.125rem;
  }

  /* Metrics Grid */
  .metrics-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--page-border);
  }

  @media (max-width: 991.98px) {
    .metrics-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 575.98px) {
    .metrics-grid {
      grid-template-columns: 1fr;
    }
  }

  .metric-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .metric-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--page-primary);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .metric-icon i {
    font-size: 1.25rem;
  }

  .metric-content {
    flex: 1;
    min-width: 0;
  }

  .metric-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1e293b;
  }

  .metric-label {
    font-size: 0.75rem;
    color: var(--page-muted);
  }

  /* Publications Card */
  .publications-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    overflow: hidden;
  }

  .publications-tabs {
    padding: 1rem 1.5rem 0;
    border-bottom: 1px solid var(--page-border);
    overflow-x: auto;
    white-space: nowrap;
  }

  .publications-tabs::-webkit-scrollbar {
    height: 4px;
  }

  .publications-tabs::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }

  .nav-pills-custom {
    display: flex;
    gap: 0.5rem;
    margin-bottom: -1px;
  }

  .nav-pills-custom .nav-link {
    border-radius: var(--page-radius-sm) var(--page-radius-sm) 0 0;
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #475569;
    background: #f1f5f9;
    border: 1px solid transparent;
    border-bottom: none;
    white-space: nowrap;
    transition: all 0.2s ease;
  }

  .nav-pills-custom .nav-link:hover {
    background: var(--page-primary-light);
    color: var(--page-primary);
  }

  .nav-pills-custom .nav-link.active {
    background: #ffffff;
    color: var(--page-primary);
    border-color: var(--page-border);
    border-bottom: 1px solid #ffffff;
  }

  .publications-content {
    padding: 1.5rem;
  }

  .publication-item {
    padding: 1rem;
    margin: -1rem;
    margin-bottom: 1rem;
    border-radius: var(--page-radius-sm);
    transition: background-color 0.15s ease;
  }

  .publication-item:hover {
    background: #f8fafc;
  }

  .publication-item:last-child {
    margin-bottom: 0;
    border-bottom: none;
    padding-bottom: 0;
  }

  .publication-title {
    font-size: 0.9375rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .publication-title a {
    color: var(--page-primary);
    text-decoration: none;
  }

  .publication-title a:hover {
    text-decoration: underline;
  }

  .publication-program {
    font-size: 0.8125rem;
    color: var(--page-muted);
    margin-bottom: 0.5rem;
  }

  .publication-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    align-items: center;
    margin-bottom: 0.5rem;
  }

  .publication-journal {
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--page-primary);
  }

  .publication-badge {
    display: inline-flex;
    padding: 0.25rem 0.625rem;
    background: var(--page-primary-light);
    color: var(--page-primary);
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
  }

  .publication-info {
    display: flex;
    gap: 1rem;
    font-size: 0.8125rem;
    color: var(--page-muted);
  }

  .publication-info i {
    margin-right: 0.25rem;
  }

  .publication-info a {
    color: var(--page-primary);
    text-decoration: none;
  }

  .publication-info a:hover {
    text-decoration: underline;
  }

  /* Pagination */
  .pagination-wrapper {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--page-border);
  }

  .pagination {
    margin: 0;
    gap: 0.25rem;
    justify-content: center;
  }

  .page-link {
    border-radius: var(--page-radius-sm);
    border: 1px solid var(--page-border);
    color: #475569;
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
  }

  .page-link:hover {
    background: var(--page-primary-light);
    border-color: var(--page-primary);
    color: var(--page-primary);
  }

  .page-item.active .page-link {
    background: var(--page-primary);
    border-color: var(--page-primary);
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

  /* Responsive */
  @media (max-width: 767.98px) {
    .profile-header {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .profile-meta {
      align-items: center;
    }

    .profile-info {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .metrics-grid {
      gap: 0.75rem;
    }

    .metric-item {
      padding: 0.75rem;
      background: #f8fafc;
      border-radius: var(--page-radius-sm);
    }
  }
</style>

<div class="container py-4" style="max-width: 1400px;">

  <!-- Back Button -->
  <a href="<?php echo BASE_URL; ?>penelitian" class="page-back-btn">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Daftar
  </a>

  <!-- Profile Card -->
  <div class="profile-card">
    <div class="profile-card-body">
      <div class="row">
        <!-- Profile Info Column -->
        <div class="col-lg-8">
          <div class="profile-header">
            <div class="profile-avatar">
              <i class="bi bi-person-fill"></i>
            </div>
            <div class="profile-info">
              <h1 class="profile-name">
                <?php echo htmlspecialchars($dosen['name']); ?>
                <i class="bi bi-check-circle-fill profile-verified" title="Verified"></i>
              </h1>
              <div class="profile-meta">
                <div class="profile-meta-item">
                  <i class="bi bi-geo-alt-fill"></i>
                  <span>Universitas Komputer Indonesia</span>
                </div>
                <div class="profile-meta-item">
                  <i class="bi bi-building-fill"></i>
                  <span><?php echo htmlspecialchars($dosen['faculty']); ?></span>
                </div>
                <div class="profile-meta-item">
                  <i class="bi bi-person-badge-fill"></i>
                  <span>SINTA ID: <?php echo htmlspecialchars($dosen['nidn']); ?></span>
                </div>
              </div>
              <span class="profile-tag"><?php echo htmlspecialchars($dosen['subject_research']); ?></span>
            </div>
          </div>

          <!-- Metrics -->
          <div class="metrics-grid">
            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-journal-text"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo $dosen['jumlah_jurnal']; ?></div>
                <div class="metric-label">Jumlah Jurnal</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-graph-up"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo number_format($dosen['sinta_score'], 2); ?></div>
                <div class="metric-label">SINTA Score</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-bar-chart"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo number_format($dosen['sinta_score_3yr'], 2); ?></div>
                <div class="metric-label">SINTA 3Yr</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-building-fill"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo number_format($dosen['affil_score'], 2); ?></div>
                <div class="metric-label">Affil Score</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-building"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo number_format($dosen['affil_score_3yr'], 2); ?></div>
                <div class="metric-label">Affil 3Yr</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-bookmark-star"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo $dosen['scopus_h_index']; ?></div>
                <div class="metric-label">Scopus H-Index</div>
              </div>
            </div>

            <div class="metric-item">
              <div class="metric-icon">
                <i class="bi bi-google"></i>
              </div>
              <div class="metric-content">
                <div class="metric-value"><?php echo $dosen['gs_h_index']; ?></div>
                <div class="metric-label">GS H-Index</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Stats Column -->
        <div class="col-lg-4 mt-4 mt-lg-0">
          <div class="stats-card">
            <div class="stats-header">
              <h6 class="stats-title">Rasio Kontribusi Penulis</h6>
              <select class="form-select form-select-sm stats-select" id="statsYear" onchange="filterStats(this.value)">
                <?php
                $currentYear = date('Y');
                $years = [];
                for ($i = $currentYear; $i >= $currentYear - 4; $i--) {
                  $years[] = $i;
                }

                foreach ($years as $year) {
                  $selected = ($year == $statsYear) ? 'selected' : '';
                  echo "<option value='$year' $selected>$year</option>";
                }
                ?>
                <option value="Semua Tahun" <?php echo ($statsYear == 'Semua Tahun') ? 'selected' : ''; ?>>Semua Tahun</option>
              </select>
            </div>

            <div class="stats-grid">
              <div class="stats-item">
                <div class="stats-label">Penulis Utama</div>
                <div class="stats-value"><?php echo $dosen['rasio_utama']; ?>%</div>
              </div>
              <div class="stats-item info">
                <div class="stats-label">Co-Author</div>
                <div class="stats-value"><?php echo $dosen['rasio_coauthor']; ?>%</div>
              </div>
            </div>

            <div class="stats-note">
              <i class="bi bi-info-circle-fill"></i>
              <?php if ($statsYear == 'Semua Tahun'): ?>
                <span>Berdasarkan seluruh total publikasi yang tercatat.</span>
              <?php else: ?>
                <span>Berdasarkan publikasi pada tahun <strong><?php echo $statsYear; ?></strong>.</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Publications Card -->
  <div class="publications-card">
    <div class="publications-tabs">
      <ul class="nav nav-pills-custom" id="publicationType" role="tablist">
        <?php foreach ($categorizedPublications as $journal => $catInfo): ?>
          <?php
          $sanitizedId = 'j_' . substr(md5($journal), 0, 8);
          $isActive = ($activeTab === $journal);
          $label = $journal;
          ?>
          <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo $isActive ? 'active' : ''; ?>" id="<?php echo $sanitizedId; ?>-tab"
              data-bs-toggle="pill" data-bs-target="#tab-<?php echo $sanitizedId; ?>" type="button" role="tab"
              title="<?php echo htmlspecialchars($journal); ?>">
              <span class="text-truncate d-inline-block" style="max-width: 180px;">
                <?php echo htmlspecialchars($label); ?>
              </span>
              <span class="ms-1">(<?php echo $catInfo['totalCount']; ?>)</span>
            </button>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="tab-content publications-content" id="publicationTypeContent">
      <?php if (empty($categorizedPublications)): ?>
        <div class="empty-state">
          <i class="bi bi-journal-x"></i>
          <p>Tidak ada data publikasi untuk dosen ini.</p>
        </div>
      <?php endif; ?>

      <?php foreach ($categorizedPublications as $journal => $catInfo): ?>
        <?php
        $sanitizedId = 'j_' . substr(md5($journal), 0, 8);
        $isActive = ($activeTab === $journal);
        ?>
        <div class="tab-pane fade <?php echo $isActive ? 'show active' : ''; ?>" id="tab-<?php echo $sanitizedId; ?>" role="tabpanel">
          <?php foreach ($catInfo['data'] as $index => $pub): ?>
            <div class="publication-item <?php echo $index < count($catInfo['data']) - 1 ? 'border-bottom pb-4 mb-4' : ''; ?>">
              <h6 class="publication-title">
                <a href="#"><?php echo htmlspecialchars($pub['title']); ?></a>
              </h6>
              <p class="publication-program"><?php echo htmlspecialchars($pub['program_studi']); ?></p>
              <div class="publication-meta">
                <span class="publication-journal"><?php echo htmlspecialchars($pub['journal_title']); ?></span>
                <span class="publication-badge"><?php echo htmlspecialchars($pub['publisher']); ?></span>
              </div>
              <div class="publication-info">
                <span>
                  <i class="bi bi-calendar3"></i>
                  <?php echo $pub['year']; ?>
                </span>
                <span>
                  <i class="bi bi-link-45deg"></i>
                  DOI: <a href="https://doi.org/<?php echo htmlspecialchars($pub['doi']); ?>" target="_blank">
                    <?php echo htmlspecialchars($pub['doi']); ?>
                  </a>
                </span>
              </div>
            </div>
          <?php endforeach; ?>

          <!-- Pagination -->
          <?php if ($catInfo['totalPages'] > 1): ?>
            <div class="pagination-wrapper">
              <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">
                  <li class="page-item <?php echo ($catInfo['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo urlencode($journal); ?>&<?php echo $catInfo['paramKey']; ?>=1">
                      <i class="bi bi-chevron-double-left"></i>
                    </a>
                  </li>
                  <li class="page-item <?php echo ($catInfo['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo urlencode($journal); ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['currentPage'] - 1; ?>">
                      <i class="bi bi-chevron-left"></i>
                    </a>
                  </li>

                  <?php
                  $maxPagesToShow = 5;
                  $startPage = max(1, $catInfo['currentPage'] - floor($maxPagesToShow / 2));
                  $endPage = min($catInfo['totalPages'], $startPage + $maxPagesToShow - 1);

                  if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max(1, $endPage - $maxPagesToShow + 1);
                  }

                  for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <li class="page-item <?php echo ($i == $catInfo['currentPage']) ? 'active' : ''; ?>">
                      <a class="page-link" href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo urlencode($journal); ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                  <?php endfor; ?>

                  <li class="page-item <?php echo ($catInfo['currentPage'] >= $catInfo['totalPages']) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo urlencode($journal); ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['currentPage'] + 1; ?>">
                      <i class="bi bi-chevron-right"></i>
                    </a>
                  </li>
                  <li class="page-item <?php echo ($catInfo['currentPage'] >= $catInfo['totalPages']) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo urlencode($journal); ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['totalPages']; ?>">
                      <i class="bi bi-chevron-double-right"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

</div>

<script>
  function filterStats(year) {
    const url = new URL(window.location.href);
    url.searchParams.set('statsYear', year);
    window.location.href = url.toString();
  }
</script>