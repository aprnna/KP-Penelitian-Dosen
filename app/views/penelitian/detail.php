<div class="container py-4" style="max-width: 1400px;">
  <!-- Header with Back Button -->
  <div class="row mb-4">
    <div class="col-12">
      <a href="<?php echo BASE_URL; ?>penelitian" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
    </div>
  </div>

  <!-- Main Content Card -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
          <!-- Profile Section -->
          <div class="row mb-4">
            <!-- Profile Photo -->
            <div class="col-md-2 text-center mb-3 mb-md-0">
              <div class="profile-photo mx-auto"
                style="width: 140px; height: 140px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="bi bi-person-fill text-white" style="font-size: 4rem;"></i>
              </div>
            </div>

            <!-- Profile Info -->
            <div class="col-md-10">
              <div class="d-flex align-items-start mb-3">
                <h2 class="fw-bold mb-0 me-2"><?php echo htmlspecialchars($dosen['name']); ?></h2>
                <i class="bi bi-check-circle-fill text-success" style="font-size: 1.5rem;"></i>
              </div>

              <div class="text-muted mb-2">
                <i class="bi bi-geo-alt-fill me-2"></i>
                <span>Universitas Komputer Indonesia</span>
              </div>
              <div class="text-muted mb-2">
                <i class="bi bi-building-fill me-2"></i>
                <span><?php echo htmlspecialchars($dosen['faculty']); ?></span>
              </div>
              <div class="text-muted mb-3">
                <i class="bi bi-person-badge-fill me-2"></i>
                <span>SINTA ID: <?php echo htmlspecialchars($dosen['nidn']); ?></span>
              </div>

              <div>
                <span
                  class="badge bg-light text-primary px-3 py-2"><?php echo htmlspecialchars($dosen['subject_research']); ?></span>
              </div>
            </div>
          </div>

          <!-- Metrics Section -->
          <div class="row g-4 mt-3">
            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-journal-text text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo $dosen['jumlah_jurnal']; ?></h4>
                  <small class="text-muted">Jumlah Jurnal</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-graph-up text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo number_format($dosen['sinta_score'], 2); ?></h4>
                  <small class="text-muted">SINTA Score Overall</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-bar-chart text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo number_format($dosen['sinta_score_3yr'], 2); ?></h4>
                  <small class="text-muted">SINTA Score 3Yr</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-building-fill text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo number_format($dosen['affil_score'], 2); ?></h4>
                  <small class="text-muted">Affil Score</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-building text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo number_format($dosen['affil_score_3yr'], 2); ?></h4>
                  <small class="text-muted">Affil Score 3Yr</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-bookmark-star text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo $dosen['scopus_h_index']; ?></h4>
                  <small class="text-muted">Scopus H-Index</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-google text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo $dosen['gs_h_index']; ?></h4>
                  <small class="text-muted">GS H-Index</small>
                </div>
              </div>
            </div>

            <div class="col-6 col-md-3 text-center">
              <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="metric-icon me-3 bg-primary"
                  style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="bi bi-people-fill text-white" style="font-size: 1.5rem;"></i>
                </div>
                <div class="text-start">
                  <h4 class="fw-bold mb-0"><?php echo $dosen['rasio_utama']; ?>:<?php echo $dosen['rasio_coauthor']; ?>
                  </h4>
                  <small class="text-muted">Rasio Penulis</small>
                </div>
              </div>
            </div>
          </div>
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