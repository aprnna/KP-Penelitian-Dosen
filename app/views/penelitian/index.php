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
      <label class="form-label small text-muted">Jurusan</label>
      <select class="form-select" id="jurusanFilter">
        <option selected>Semua Jurusan</option>
        <option>Teknik Informatika</option>
        <option>Sistem Informasi</option>
        <option>Ilmu Manajemen</option>
        <option>Ilmu Hukum</option>
        <option>Ekonomi</option>
        <option>Akuntansi</option>
      </select>
    </div>
    <div class="col-md-5">
      <label class="form-label small text-muted">Nama Dosen</label>
      <input type="text" class="form-control" id="dosenSearch" placeholder="Masukkan nama dosen">
    </div>
  </div>

  <!-- Data Table Card -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
          <h5 class="mb-0 fw-bold">Pencarian Penelitian Berdasarkan Dosen</h5>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="bg-light">
                <tr>
                  <th class="py-3 px-4 border-0">
                    <div class="d-flex align-items-center">
                      <span
                        class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-person-circle text-white"></i>
                      </span>
                      <span class="fw-bold">Information Lecture</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-journal-text text-white"></i>
                      </span>
                      <span class="fw-bold">Jumlah Jurnal</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-graph-up text-white"></i>
                      </span>
                      <span class="fw-bold">Skor Relevansi</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-bookmark-check text-white"></i>
                      </span>
                      <span class="fw-bold">H-index</span>
                    </div>
                  </th>
                  <th class="py-3 px-4 border-0 text-center">
                    <div class="d-flex align-items-center justify-content-center">
                      <span
                        class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center me-2"
                        style="width: 32px; height: 32px;">
                        <i class="bi bi-award text-white"></i>
                      </span>
                      <span class="fw-bold">i10-index</span>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($penelitianData as $index => $dosen): ?>
                  <?php
                  $name = $dosen['name'];
                  // Use NIDN for display ID
                  $id = $dosen['nidn'];
                  $faculty = $dosen['faculty'];
                  $jumlah_jurnal = $dosen['jumlah_jurnal'];
                  $skor_relevansi = $dosen['skor_relevansi'];
                  $h_index = $dosen['h_index'];
                  $i10_index = $dosen['i10_index'];
                  $isAlternate = $index % 2 == 1;
                  // Use database primary key for URL
                  $detailUrl = BASE_URL . 'penelitian/detail/' . $dosen['id_author'];
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
              <!-- First Page -->
              <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=1" aria-label="First">
                  <span aria-hidden="true">&laquo; First</span>
                </a>
              </li>

              <!-- Previous Page -->
              <li class="page-item <?php echo ($currentPage <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
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
                  <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
              <?php endfor; ?>

              <!-- Next Page -->
              <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                  <span aria-hidden="true">&rsaquo;</span>
                </a>
              </li>

              <!-- Last Page -->
              <li class="page-item <?php echo ($currentPage >= $totalPages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $totalPages; ?>" aria-label="Last">
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
  // Search functionality
  document.getElementById('dosenSearch').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
      const dosenName = row.querySelector('td:first-child span').textContent.toLowerCase();
      if (dosenName.includes(searchTerm)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });

  // Filter functionality
  document.getElementById('jurusanFilter').addEventListener('change', function (e) {
    const selectedJurusan = e.target.value;
    const tableRows = document.querySelectorAll('tbody tr');

    if (selectedJurusan === 'Semua Jurusan') {
      tableRows.forEach(row => row.style.display = '');
      return;
    }

    tableRows.forEach(row => {
      const faculty = row.querySelector('td:first-child small:last-child').textContent;
      if (faculty.includes(selectedJurusan)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });

  // Clickable rows
  document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function () {
      window.location.href = this.dataset.href;
    });
  });
</script>