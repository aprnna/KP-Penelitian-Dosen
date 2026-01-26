<div class="container py-4" style="max-width: 1400px;">
  <!-- Header with Back Button -->
  <div class="row mb-4">
    <div class="col-12">
      <a href="<?php echo BASE_URL; ?>penelitian" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </div>

  <!-- Main Content Row -->
  <div class="row g-4 mb-4">
    <!-- Left Column: Dosen Info + Metrics -->
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <!-- Dosen Name and Info -->
          <h3 class="fw-bold mb-2"><?php echo htmlspecialchars($dosen['name']); ?></h3>
          <div class="mb-4">
            <p class="mb-1">
              <i class="bi bi-credit-card-2-front text-primary me-2"></i>
              NIDN:<?php echo htmlspecialchars($dosen['nidn']); ?>
            </p>
            <p class="mb-0">
              <i class="bi bi-building text-primary me-2"></i>
              <?php echo htmlspecialchars($dosen['faculty']); ?>
            </p>
          </div>

          <!-- Metrics Row -->
          <div class="row g-3 text-center">
            <div class="col-6 col-md-3">
              <div class="metric-circle mx-auto mb-2"
                style="width: 100px; height: 100px; background-color: #ffa726; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <i class="bi bi-person-circle text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="fw-bold mb-0"><?php echo $dosen['jumlah_jurnal']; ?></h4>
              <small class="text-muted">Jumlah<br>Jurnal</small>
            </div>
            <div class="col-6 col-md-3">
              <div class="metric-circle mx-auto mb-2"
                style="width: 100px; height: 100px; background-color: #ffa726; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <i class="bi bi-journal-text text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="fw-bold mb-0"><?php echo $dosen['skor_relevansi']; ?></h4>
              <small class="text-muted">Skor<br>Relevansi</small>
            </div>
            <div class="col-6 col-md-3">
              <div class="metric-circle mx-auto mb-2"
                style="width: 100px; height: 100px; background-color: #ffa726; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <i class="bi bi-mortarboard text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="fw-bold mb-0"><?php echo $dosen['h_index']; ?></h4>
              <small class="text-muted">H-index</small>
            </div>
            <div class="col-6 col-md-3">
              <div class="metric-circle mx-auto mb-2"
                style="width: 100px; height: 100px; background-color: #ffa726; border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <i class="bi bi-bookmark-check text-white" style="font-size: 2rem;"></i>
              </div>
              <h4 class="fw-bold mb-0"><?php echo $dosen['i10_index']; ?></h4>
              <small class="text-muted">i10-index</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Rasio Penulis -->
    <div class="col-lg-5">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center text-center">
          <h6 class="text-muted mb-3">Rasio Penulis</h6>
          <h1 class="display-1 fw-bold mb-3"><?php echo $dosen['rasio_utama']; ?> :
            <?php echo $dosen['rasio_coauthor']; ?>
          </h1>
          <p class="text-muted mb-0">Rasio Penulis Utama vs Co-Author</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Publications List -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
          <!-- Filter Tabs -->
          <div class="border-bottom px-4 pt-3">
            <ul class="nav nav-pills mb-3" id="publicationType" role="tablist">
              <?php foreach ($categorizedPublications as $type => $catInfo): ?>
                <?php
                $sanitizedId = str_replace('-', '_', $type);
                $isActive = ($activeTab === $type);
                // Prettify type label (e.g. journal-article -> Journal Article)
                $label = ucwords(str_replace('-', ' ', $type));
                ?>
                <li class="nav-item" role="presentation">
                  <button class="nav-link <?php echo $isActive ? 'active' : ''; ?>" id="<?php echo $sanitizedId; ?>-tab"
                    data-bs-toggle="pill" data-bs-target="#tab-<?php echo $sanitizedId; ?>" type="button" role="tab">
                    <?php echo $label; ?> (<?php echo $catInfo['totalCount']; ?>)
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- Publications List -->
          <div class="tab-content p-4" id="publicationTypeContent">
            <?php if (empty($categorizedPublications)): ?>
              <div class="text-center py-5">
                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada data publikasi untuk dosen ini.</p>
              </div>
            <?php endif; ?>

            <?php foreach ($categorizedPublications as $type => $catInfo): ?>
              <?php
              $sanitizedId = str_replace('-', '_', $type);
              $isActive = ($activeTab === $type);
              ?>
              <div class="tab-pane fade <?php echo $isActive ? 'show active' : ''; ?>"
                id="tab-<?php echo $sanitizedId; ?>" role="tabpanel">

                <?php foreach ($catInfo['data'] as $index => $pub): ?>
                  <div
                    class="publication-item mb-4 pb-4 <?php echo $index < count($catInfo['data']) - 1 ? 'border-bottom' : ''; ?>">
                    <h6 class="text-primary mb-2">
                      <a href="#" class="text-decoration-none"><?php echo htmlspecialchars($pub['title']); ?></a>
                    </h6>
                    <p class="text-muted small mb-2"><?php echo htmlspecialchars($pub['program_studi']); ?></p>
                    <div class="mb-2">
                      <span class="text-primary fw-bold small me-3">
                        <?php echo htmlspecialchars($pub['journal']); ?>
                      </span>
                      <span class="badge bg-primary">
                        <?php echo htmlspecialchars($pub['journal_name']); ?>
                      </span>
                    </div>
                    <div class="d-flex gap-3 small text-muted">
                      <span>
                        <i class="bi bi-calendar3 me-1"></i>
                        <?php echo $pub['year']; ?>
                      </span>
                      <span>
                        <i class="bi bi-link-45deg me-1"></i>
                        DOI: <a href="https://doi.org/<?php echo htmlspecialchars($pub['doi']); ?>" target="_blank"
                          class="text-primary text-decoration-none"><?php echo htmlspecialchars($pub['doi']); ?></a>
                      </span>
                    </div>
                  </div>
                <?php endforeach; ?>

                <!-- Pagination for this type -->
                <?php if ($catInfo['totalPages'] > 1): ?>
                  <div class="mt-4">
                    <nav aria-label="Page navigation for <?php echo $type; ?>">
                      <ul class="pagination pagination-sm justify-content-center mb-0">
                        <!-- First Page -->
                        <li class="page-item <?php echo ($catInfo['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                          <a class="page-link"
                            href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo $type; ?>&<?php echo $catInfo['paramKey']; ?>=1"
                            aria-label="First">
                            <span aria-hidden="true">&laquo; First</span>
                          </a>
                        </li>

                        <!-- Previous Page -->
                        <li class="page-item <?php echo ($catInfo['currentPage'] <= 1) ? 'disabled' : ''; ?>">
                          <a class="page-link"
                            href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo $type; ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['currentPage'] - 1; ?>"
                            aria-label="Previous">
                            <span aria-hidden="true">&lsaquo;</span>
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
                            <a class="page-link"
                              href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo $type; ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $i; ?>"><?php echo $i; ?></a>
                          </li>
                        <?php endfor; ?>

                        <!-- Next Page -->
                        <li
                          class="page-item <?php echo ($catInfo['currentPage'] >= $catInfo['totalPages']) ? 'disabled' : ''; ?>">
                          <a class="page-link"
                            href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo $type; ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['currentPage'] + 1; ?>"
                            aria-label="Next">
                            <span aria-hidden="true">&rsaquo;</span>
                          </a>
                        </li>

                        <!-- Last Page -->
                        <li
                          class="page-item <?php echo ($catInfo['currentPage'] >= $catInfo['totalPages']) ? 'disabled' : ''; ?>">
                          <a class="page-link"
                            href="?page_id=<?php echo $dosen['id']; ?>&tab=<?php echo $type; ?>&<?php echo $catInfo['paramKey']; ?>=<?php echo $catInfo['totalPages']; ?>"
                            aria-label="Last">
                            <span aria-hidden="true">Last &raquo;</span>
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
    </div>
  </div>
</div>

<style>
  .nav-pills .nav-link {
    color: #333;
    background-color: #e9ecef;
    border-radius: 8px;
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    margin-right: 0.5rem;
  }

  .nav-pills .nav-link.active {
    background-color: #0066cc;
    color: white;
  }

  .publication-item:hover {
    background-color: #f8f9fa;
    padding: 1rem;
    margin: -1rem;
    margin-bottom: 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
  }

  .publication-item a:hover {
    text-decoration: underline !important;
  }
</style>