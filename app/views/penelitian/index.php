<!-- Page-specific styles for consistent design -->
<style>
  /* Design System (consistent with scraping page) */
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

  .page-header {
    margin-bottom: 1.5rem;
  }

  .page-header h4 {
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
  }

  .page-header p {
    color: var(--page-muted);
    font-size: 0.875rem;
    margin: 0;
  }

  /* Filter Card */
  .filter-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    padding: 1.25rem;
    margin-bottom: 1.5rem;
  }

  .filter-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--page-muted);
    margin-bottom: 0.5rem;
  }

  .filter-select,
  .filter-input {
    border-radius: var(--page-radius-sm);
    border-color: var(--page-border);
    font-size: 0.875rem;
    padding: 0.625rem 0.875rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .filter-select:focus,
  .filter-input:focus {
    border-color: var(--page-primary);
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
  }

  .filter-input::placeholder {
    color: #94a3b8;
  }

  /* Data Card */
  .data-card {
    background: #ffffff;
    border-radius: var(--page-radius);
    box-shadow: var(--page-card-shadow);
    border: 1px solid var(--page-border);
    overflow: hidden;
  }

  .data-card-header {
    background: #f8fafc;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--page-border);
  }

  .data-card-header h5 {
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .data-card-header h5 i {
    color: var(--page-primary);
  }

  /* Table */
  .data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .data-table thead th {
    background: #f8fafc;
    padding: 1rem 1.25rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--page-muted);
    border-bottom: 1px solid var(--page-border);
    text-align: left;
    vertical-align: middle;
  }

  .data-table thead th.center {
    text-align: center;
  }

  .data-table tbody tr {
    cursor: pointer;
    transition: background-color 0.15s ease;
  }

  .data-table tbody tr:hover {
    background-color: #f8fafc;
  }

  .data-table tbody td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--page-border);
    vertical-align: middle;
  }

  .data-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Dosen Info Cell */
  .dosen-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
  }

  .dosen-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 0.9375rem;
  }

  .dosen-meta {
    font-size: 0.8125rem;
    color: var(--page-muted);
    display: flex;
    align-items: center;
    gap: 0.25rem;
  }

  .dosen-meta i {
    color: var(--page-primary);
    font-size: 0.75rem;
  }

  .dosen-badges {
    display: flex;
    gap: 1rem;
    margin-top: 0.375rem;
  }

  .dosen-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--page-muted);
  }

  .dosen-badge i {
    color: var(--page-primary);
  }

  .dosen-badge strong {
    color: #475569;
  }

  /* Score Cell */
  .score-cell {
    text-align: center;
    font-weight: 600;
    font-size: 1rem;
    color: #1e293b;
  }

  /* Pagination */
  .pagination-wrapper {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--page-border);
    background: #ffffff;
  }

  .pagination {
    margin: 0;
    gap: 0.25rem;
  }

  .page-link {
    border-radius: var(--page-radius-sm);
    border: 1px solid var(--page-border);
    color: #475569;
    padding: 0.5rem 0.875rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
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

  .page-item.disabled .page-link {
    background: #f8fafc;
    color: #94a3b8;
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

  /* Table Header Icons */
  .th-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--page-primary-light);
    color: var(--page-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.5rem;
    font-size: 0.875rem;
  }

  .th-content {
    display: flex;
    align-items: center;
  }

  .th-content.center {
    justify-content: center;
  }

  /* Responsive */
  @media (max-width: 991.98px) {
    .data-table {
      display: block;
      overflow-x: auto;
      white-space: nowrap;
    }

    .dosen-badges {
      flex-direction: column;
      gap: 0.25rem;
    }
  }
</style>

<div class="container py-4" style="max-width: 1400px;">

  <!-- Page Header -->
  <div class="page-header">
    <h4>Penelitian Dosen</h4>
    <p>Daftar dosen dengan data publikasi dan skor SINTA</p>
  </div>

  <!-- Filters -->
  <div class="filter-card">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="filter-label">Fakultas</label>
        <select class="form-select filter-select" id="fakultasFilter">
          <option value="Semua Fakultas">Semua Fakultas</option>
          <?php foreach ($faculties as $fac): ?>
            <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php echo (isset($faculty) && $faculty === $fac->faculty) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($fac->faculty); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="filter-label">Cari Dosen</label>
        <input type="text" class="form-control filter-input" id="dosenSearch" placeholder="Ketik nama dosen..."
          value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="button" class="btn btn-primary w-100" id="btnSearch" style="border-radius: var(--page-radius-sm); background: var(--page-primary); border-color: var(--page-primary);">
          <i class="bi bi-search me-1"></i> Cari
        </button>
      </div>
    </div>
  </div>

  <!-- Data Table -->
  <div class="data-card">
    <div class="data-card-header">
      <h5>
        <i class="bi bi-people-fill"></i>
        Daftar Dosen
      </h5>
    </div>

    <div class="table-responsive">
      <table class="data-table">
        <thead>
          <tr>
            <th>
              <div class="th-content">
                <span class="th-icon"><i class="bi bi-person-fill"></i></span>
                <span>Informasi Dosen</span>
              </div>
            </th>
            <th class="center">
              <div class="th-content center">
                <span class="th-icon"><i class="bi bi-journal-text"></i></span>
                <span>Jurnal</span>
              </div>
            </th>
            <th class="center">
              <div class="th-content center">
                <span class="th-icon"><i class="bi bi-graph-up"></i></span>
                <span>SINTA 3Yr</span>
              </div>
            </th>
            <th class="center">
              <div class="th-content center">
                <span class="th-icon"><i class="bi bi-bar-chart"></i></span>
                <span>SINTA Score</span>
              </div>
            </th>
            <th class="center">
              <div class="th-content center">
                <span class="th-icon"><i class="bi bi-building"></i></span>
                <span>Affil 3Yr</span>
              </div>
            </th>
            <th class="center">
              <div class="th-content center">
                <span class="th-icon"><i class="bi bi-building-fill"></i></span>
                <span>Affil Score</span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($penelitianData)): ?>
            <tr>
              <td colspan="6">
                <div class="empty-state">
                  <i class="bi bi-search"></i>
                  <p>Tidak ada data dosen yang ditemukan.</p>
                </div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($penelitianData as $index => $dosen): ?>
              <?php
              $name = $dosen['name'];
              $id = $dosen['nidn'];
              $faculty = $dosen['faculty'];
              $jumlah_jurnal = $dosen['jumlah_jurnal'];
              $sinta_score_3yr = $dosen['sinta_score_3yr'];
              $sinta_score = $dosen['sinta_score'];
              $affil_score_3yr = $dosen['affil_score_3yr'];
              $affil_score = $dosen['affil_score'];
              $scopus_h_index = $dosen['scopus_h_index'];
              $gs_h_index = $dosen['gs_h_index'];
              $isAlternate = $index % 2 == 1;
              $detailUrl = BASE_URL . 'penelitian/detail/' . $dosen['id_sinta'];
              include '../app/views/components/penelitian_row.php';
              ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
      <div class="pagination-wrapper">
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center mb-0">
            <!-- First Page -->
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo buildPaginationUrl(1, $faculty, $search); ?>" aria-label="First">
                <i class="bi bi-chevron-double-left"></i>
              </a>
            </li>

            <!-- Previous Page -->
            <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo buildPaginationUrl($currentPage - 1, $faculty, $search); ?>" aria-label="Previous">
                <i class="bi bi-chevron-left"></i>
              </a>
            </li>

            <?php
            $maxPagesToShow = 5;
            $startPage = max(1, $currentPage - floor($maxPagesToShow / 2));
            $endPage = min($totalPages, $startPage + $maxPagesToShow - 1);

            if ($endPage - $startPage + 1 < $maxPagesToShow) {
              $startPage = max(1, $endPage - $maxPagesToShow + 1);
            }

            for ($i = $startPage; $i <= $endPage; $i++): ?>
              <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo buildPaginationUrl($i, $faculty, $search); ?>"><?php echo $i; ?></a>
              </li>
            <?php endfor; ?>

            <!-- Next Page -->
            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo buildPaginationUrl($currentPage + 1, $faculty, $search); ?>" aria-label="Next">
                <i class="bi bi-chevron-right"></i>
              </a>
            </li>

            <!-- Last Page -->
            <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
              <a class="page-link" href="<?php echo buildPaginationUrl($totalPages, $faculty, $search); ?>" aria-label="Last">
                <i class="bi bi-chevron-double-right"></i>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    <?php endif; ?>

  </div>
</div>

<script>
  // Search with debounce
  let searchTimeout;
  const searchInput = document.getElementById('dosenSearch');
  const facultySelect = document.getElementById('fakultasFilter');
  const searchBtn = document.getElementById('btnSearch');

  function applyFilters() {
    const faculty = facultySelect.value;
    const search = searchInput.value.trim();

    const params = new URLSearchParams();
    params.set('page', '1');

    if (faculty && faculty !== 'Semua Fakultas') {
      params.set('faculty', faculty);
    }

    if (search) {
      params.set('search', search);
    }

    window.location.href = '?' + params.toString();
  }

  // Debounced search
  searchInput.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(applyFilters, 600);
  });

  // Search on Enter
  searchInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      clearTimeout(searchTimeout);
      applyFilters();
    }
  });

  // Filter on change
  facultySelect.addEventListener('change', applyFilters);

  // Search button
  searchBtn.addEventListener('click', function() {
    clearTimeout(searchTimeout);
    applyFilters();
  });

  // Clickable rows
  document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function() {
      window.location.href = this.dataset.href;
    });
  });

  // Helper function for pagination URLs
  <?php
  function buildPaginationUrl($page, $faculty = null, $search = null) {
    $params = ['page' => $page];
    if ($faculty && $faculty !== 'Semua Fakultas') {
      $params['faculty'] = $faculty;
    }
    if ($search) {
      $params['search'] = $search;
    }
    return '?' . http_build_query($params);
  }
  ?>
</script>