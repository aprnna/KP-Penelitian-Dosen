<div class="container py-4" style="max-width: 1400px;">
  <!-- Page Title -->
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="fw-bold mb-0">Penelitian Dosen</h4>
    </div>
  </div>

  <!-- Filters -->
  <div class="row mb-4">
    <div class="col-md-3">
      <label class="form-label small text-muted">Fakultas</label>
      <select class="form-select" id="fakultasFilter">
        <option value="Semua Fakultas">Semua Fakultas</option>
        <?php foreach ($faculties as $fac): ?>
          <option value="<?php echo htmlspecialchars($fac->faculty); ?>" <?php echo (isset($faculty) && $faculty === $fac->faculty) ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($fac->faculty); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-5">
      <label class="form-label small text-muted">Nama Dosen</label>
      <input type="text" class="form-control" id="dosenSearch" placeholder="Masukkan nama dosen"
        value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
    </div>
  </div>

  <!-- Data Table Card -->
  <div class="row">
    <div class="col-12">

      <div class="card border-0 shadow-sm">
        <div class="card-header p-4 text-center">
          <h3>Pencarian Penelitian Berdasarkan Dosen</h3>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="py-3 px-4 border-0">
                    <div class="d-flex align-items-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-person-circle text-white"></i>
                      </span>
                      <span class="fw-bold">Information Lecture</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-journal-text text-white"></i>
                      </span>
                      <span class="fw-bold">Jumlah Jurnal</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-graph-up text-white"></i>
                      </span>
                      <span class="fw-bold">SINTA Score 3Yr</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-bar-chart text-white"></i>
                      </span>
                      <span class="fw-bold">SINTA Score</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-building text-white"></i>
                      </span>
                      <span class="fw-bold">Affil Score 3Yr</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-building-fill text-white"></i>
                      </span>
                      <span class="fw-bold">Affil Score</span>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
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
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div class="card-footer bg-white border-0 py-3">
          <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-0">
              <?php
              // Helper function to build pagination URLs with preserved filters
              function buildPaginationUrl($page, $faculty = null, $search = null)
              {
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
              <!-- First Page -->
              <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildPaginationUrl(1, $faculty, $search); ?>" aria-label="First">
                  <span aria-hidden="true">&laquo; First</span>
                </a>
                </l i>

                <!-- Previous Page -->
              <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildPaginationUrl($currentPage - 1, $faculty, $search); ?>"
                  aria-label="Previous">
                  <span aria-hidden="true">&lsaquo;</span>
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
                  <a class="page-link"
                    href="<?php echo buildPaginationUrl($i, $faculty, $search); ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>

              <!-- Next Page -->
              <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildPaginationUrl($currentPage + 1, $faculty, $search); ?>"
                  aria-label="Next">
                  <span aria-hidden="true">&rsaquo;</span>
                </a>
              </li>

              <!-- Last Page -->
              <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="<?php echo buildPaginationUrl($totalPages, $faculty, $search); ?>"
                  aria-label="Last">
                  <span aria-hidden="true">Last &raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Search functionality - trigger on Enter key or after delay
  let searchTimeout;
  document.getElementById('dosenSearch').addEventListener('input', function (e) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      applyFilters();
    }, 800); // Delay 800ms before triggering search
  });

  // Search on Enter key
  document.getElementById('dosenSearch').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      clearTimeout(searchTimeout);
      applyFilters();
    }
  });

  // Filter functionality - trigger immediately on change
  document.getElementById('fakultasFilter').addEventListener('change', function (e) {
    applyFilters();
  });

  // Function to apply filters by reloading page with query params
  function applyFilters() {
    const faculty = document.getElementById('fakultasFilter').value;
    const search = document.getElementById('dosenSearch').value.trim();

    const params = new URLSearchParams();
    params.set('page', '1'); // Reset to page 1 when filters change

    if (faculty && faculty !== 'Semua Fakultas') {
      params.set('faculty', faculty);
    }

    if (search) {
      params.set('search', search);
    }

    // Reload page with new params
    window.location.href = '?' + params.toString();
  }

  // Clickable rows
  document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function () {
      window.location.href = this.dataset.href;
    });
  });
</script>