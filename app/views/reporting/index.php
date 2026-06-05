<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-xl-11">
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <h3 class="mb-2">Reporting Artikel</h3>
          <p class="text-muted mb-4">Tentukan tahun start dan end terlebih dahulu, lalu tampilkan data dan export ke PDF.</p>

          <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo htmlspecialchars($errorMessage); ?>
            </div>
          <?php endif; ?>

          <form method="GET" action="<?php echo BASE_URL; ?>reporting" class="row g-3 align-items-end">
            <div class="col-12 col-md-4">
              <label class="form-label" for="start_year">Tahun Start</label>
              <input
                type="number"
                class="form-control"
                id="start_year"
                name="start_year"
                min="1900"
                max="2100"
                step="1"
                value="<?php echo htmlspecialchars($startYear ?? ''); ?>"
                placeholder="2025"
                required>
            </div>

            <div class="col-12 col-md-4">
              <label class="form-label" for="end_year">Tahun End</label>
              <input
                type="number"
                class="form-control"
                id="end_year"
                name="end_year"
                min="1900"
                max="2100"
                step="1"
                value="<?php echo htmlspecialchars($endYear ?? ''); ?>"
                placeholder="2026"
                required>
            </div>

            <div class="col-12 col-md-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                Tampilkan Reporting
              </button>
              <a href="<?php echo BASE_URL; ?>reporting" class="btn btn-outline-secondary">Reset</a>
            </div>
          </form>
        </div>
      </div>

      <?php if (!empty($startYear) && !empty($endYear) && empty($errorMessage)): ?>
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
              <strong>Hasil Reporting</strong>
              <div class="text-muted small">
                Periode Tahun: <?php echo htmlspecialchars($startYear); ?> s.d. <?php echo htmlspecialchars($endYear); ?>
              </div>
            </div>
            <a
              class="btn btn-danger btn-sm"
              href="<?php echo BASE_URL; ?>reporting/exportPdf?start_year=<?php echo urlencode($startYear); ?>&end_year=<?php echo urlencode($endYear); ?>">
              <i class="bi bi-file-earmark-pdf"></i>
              Export PDF
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th style="width: 60px;">No</th>
                  <th>Judul Artikel</th>
                  <th>Penulis</th>
                  <th>DOI</th>
                  <th>Quartile</th>
                  <th>Link Article</th>
                  <th>Jumlah Sitasi</th>
                  <th>Sumber Artikel</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($articles)): ?>
                  <?php foreach ($articles as $index => $article): ?>
                    <tr>
                      <td><?php echo (int) $index + 1; ?></td>
                      <td><?php echo htmlspecialchars($article->title ?? '-'); ?></td>
                      <td><?php echo htmlspecialchars($article->authors ?? '-'); ?></td>
                      <td><?php echo htmlspecialchars($article->doi ?? '-'); ?></td>
                      <td><?php echo htmlspecialchars($article->quartile ?? '-'); ?></td>
                      <td>
                        <?php $link = $article->url ?? ''; ?>
                        <?php if (!empty($link)): ?>
                          <a href="<?php echo htmlspecialchars($link); ?>" target="_blank" rel="noopener noreferrer">
                            <?php echo htmlspecialchars($link); ?>
                          </a>
                        <?php else: ?>
                          -
                        <?php endif; ?>
                      </td>
                      <td><?php echo htmlspecialchars((string) ($article->citation_count ?? '-')); ?></td>
                      <td><?php echo htmlspecialchars($article->article_source ?? '-'); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center text-muted py-4">Tidak ada data pada rentang tanggal tersebut.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>