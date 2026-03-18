<div class="container py-4" style="max-width: 1400px;">

  <!-- ====================================================================
       ACTION CARDS: Trigger Scraping & Sync
       ==================================================================== -->
  <div class="row g-3 mb-4">

    <!-- Card 1: Scrape Authors -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-primary text-white">
          <h6 class="mb-0 fw-semibold">
            <i class="bi bi-people-fill me-2"></i>Scrape Authors
          </h6>
        </div>
        <div class="card-body d-flex flex-column">
          <p class="text-muted small mb-3">
            Ambil profil dan bibliometrik semua dosen dari halaman afiliasi SINTA
            (ID: 528 / UNIKOM). Proses terjadi dalam dua fase:
            list afiliasi lalu detail per profil.
          </p>
          <div class="mt-auto">
            <button type="button" class="btn btn-primary w-100" id="btnScrapeAuthors">
              <i class="bi bi-arrow-down-circle-fill me-1"></i>
              Start Author Scraping
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Scrape Articles -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-success text-white">
          <h6 class="mb-0 fw-semibold">
            <i class="bi bi-journal-text me-2"></i>Scrape Articles
          </h6>
        </div>
        <div class="card-body d-flex flex-column">
          <p class="text-muted small mb-2">
            Ambil artikel dari 4 view SINTA (Scopus, Garuda, GScholar, RAMA)
            untuk author tertentu atau seluruh author yang sudah ada di database backend.
          </p>
          <div class="mb-3">
            <label class="form-label small fw-semibold mb-1">
              Pilih Dosen <span class="text-muted fw-normal">(opsional, bisa pilih banyak)</span>
            </label>
            <select class="form-select form-select-sm" id="selectArticleAuthors" multiple size="8">
              <?php foreach (($authorsForScrape ?? []) as $author): ?>
                <option value="<?php echo (int) $author['id_sinta']; ?>">
                  <?php echo htmlspecialchars($author['fullname']); ?> (ID: <?php echo (int) $author['id_sinta']; ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <div class="d-flex gap-2 mt-2">
              <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSelectAllAuthors">Pilih Semua</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" id="btnClearAllAuthors">Kosongkan</button>
            </div>
            <div class="form-text">Kosongkan pilihan untuk scrape semua author di database backend.</div>
          </div>
          <div class="mt-auto">
            <button type="button" class="btn btn-success w-100" id="btnScrapeArticles">
              <i class="bi bi-arrow-down-circle-fill me-1"></i>
              Start Article Scraping
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Sync Authors to Local DB -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-warning text-dark">
          <h6 class="mb-0 fw-semibold">
            <i class="bi bi-arrow-repeat me-2"></i>Sync ke Database Lokal
          </h6>
        </div>
        <div class="card-body d-flex flex-column">
          <p class="text-muted small mb-3">
            Tarik semua data <code>sinta_authors</code> dari KP-Backend lalu
            cocokkan dengan tabel <code>authors</code> di database lokal.
            Record yang berubah akan diupdate; record baru akan diinsert.
          </p>
          <div id="syncResult" class="alert alert-sm py-2 small d-none mb-3"></div>
          <div id="syncArticleResult" class="alert alert-sm py-2 small d-none mb-3"></div>
          <div class="mt-auto">
            <button type="button" class="btn btn-warning w-100" id="btnPreviewSync">
              <i class="bi bi-search me-1"></i>
              Preview Sync Authors
            </button>
            <button type="button" class="btn btn-outline-warning w-100 mt-2" id="btnSyncArticles">
              <i class="bi bi-journal-check me-1"></i>
              Preview Sync Articles
            </button>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /action cards -->

  <!-- ====================================================================
       LIVE PROGRESS MONITOR (hidden by default)
       ==================================================================== -->
  <div class="row mb-4" id="progressSection" style="display:none;">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-semibold">
            <i class="bi bi-activity me-2"></i>Live Progress Monitor
          </h6>
          <button class="btn btn-sm btn-light" id="btnStopMonitor">
            <i class="bi bi-x-circle me-1"></i>Tutup
          </button>
        </div>
        <div class="card-body">

          <!-- Status + Job ID -->
          <div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
            <span class="badge fs-6" id="statusBadge">Pending</span>
            <span class="text-muted small">Job ID: <code id="currentJobId">—</code></span>
            <span class="text-muted small" id="jobSourceLabel"></span>
          </div>

          <!-- Progress Bar -->
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-1">
              <span class="fw-semibold small">Progress</span>
              <span class="small" id="progressPercentage">0%</span>
            </div>
            <div class="progress" style="height:22px;">
              <div
                class="progress-bar progress-bar-striped progress-bar-animated"
                id="progressBar"
                role="progressbar"
                style="width:0%"></div>
            </div>
          </div>

          <!-- Counters Row -->
          <div class="row text-center g-2 mb-3">
            <div class="col-6 col-md-3">
              <div class="p-2 bg-light rounded">
                <div class="h4 mb-0 text-primary" id="cntTotal">0</div>
                <div class="small text-muted">Total Records</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-2 bg-light rounded">
                <div class="h4 mb-0 text-success" id="cntProcessed">0</div>
                <div class="small text-muted">Processed</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-2 bg-light rounded">
                <div class="h4 mb-0 text-info" id="cntElapsed">00:00:00</div>
                <div class="small text-muted">Elapsed</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="p-2 bg-light rounded">
                <div class="h4 mb-0 text-warning" id="cntRemaining">—</div>
                <div class="small text-muted">Est. Remaining</div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- ====================================================================
       JOB HISTORY TABLE
       ==================================================================== -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
          <h6 class="mb-0 fw-bold">Scraping Job History</h6>
          <button class="btn btn-sm btn-outline-primary" id="btnRefreshJobs">
            <i class="bi bi-arrow-clockwise me-1"></i>Refresh
          </button>
        </div>
        <div class="card-body">

          <!-- Filters -->
          <div class="row g-2 mb-3">
            <div class="col-md-4">
              <select class="form-select form-select-sm" id="filterStatus">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="running">Running</option>
                <option value="finished">Finished</option>
                <option value="failed">Failed</option>
              </select>
            </div>
            <div class="col-md-4">
              <select class="form-select form-select-sm" id="filterSource">
                <option value="">Semua Source</option>
                <option value="sinta_authors">sinta_authors</option>
                <option value="sinta_articles">sinta_articles</option>
                <option value="both">both</option>
              </select>
            </div>
            <div class="col-md-4 text-end">
              <button class="btn btn-sm btn-outline-secondary" id="btnApplyFilter">
                <i class="bi bi-funnel me-1"></i>Filter
              </button>
            </div>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Job ID</th>
                  <th>Source</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Duration</th>
                  <th>Records</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="jobsTableBody">
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    <div class="spinner-border spinner-border-sm me-2"></div>Memuat data…
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <nav aria-label="Job pagination">
            <ul class="pagination justify-content-center" id="pagination"></ul>
          </nav>

        </div>
      </div>
    </div>
  </div>

</div><!-- /container -->

<!-- ====================================================================
     JOB DETAIL MODAL
     ==================================================================== -->
<div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="jobDetailModalLabel">
          <i class="bi bi-info-circle me-2"></i>Job Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="jobDetailBody">
        <div class="text-center py-4 text-muted">
          <div class="spinner-border me-2"></div>Loading…
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ====================================================================
     JAVASCRIPT
     ==================================================================== -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    const baseUrl = '<?php echo BASE_URL; ?>';

    /* ------------------------------------------------------------------ */
    /* State                                                                */
    /* ------------------------------------------------------------------ */
    let currentJobId = null;
    let progressInterval = null;
    let currentPage = 1;

    /* ------------------------------------------------------------------ */
    /* Constants                                                            */
    /* ------------------------------------------------------------------ */
    const STATUS_COLORS = {
      pending: 'bg-secondary',
      running: 'bg-primary',
      finished: 'bg-success',
      failed: 'bg-danger',
    };

    const SOURCE_LABELS = {
      sinta_authors: '<span class="badge bg-primary">Authors</span>',
      sinta_articles: '<span class="badge bg-success">Articles</span>',
      both: '<span class="badge bg-dark">Both</span>',
    };

    /* ------------------------------------------------------------------ */
    /* Helpers                                                              */
    /* ------------------------------------------------------------------ */
    function formatDuration(seconds) {
      if (seconds === null || seconds === undefined || seconds === '--') return '—';
      seconds = Math.floor(Number(seconds));
      if (isNaN(seconds)) return '—';
      const h = Math.floor(seconds / 3600);
      const m = Math.floor((seconds % 3600) / 60);
      const s = seconds % 60;
      return `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
    }

    function formatTimestamp(dateStr) {
      if (!dateStr) return '—';
      return new Date(dateStr).toLocaleString('id-ID');
    }

    function setBtnLoading(btn, loading, originalHtml) {
      btn.disabled = loading;
      btn.innerHTML = loading ?
        '<span class="spinner-border spinner-border-sm me-1"></span>Processing…' :
        originalHtml;
    }

    function escapeHtml(value) {
      return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }

    function getSourceLabel(source) {
      return SOURCE_LABELS[source] ?? `<span class="badge bg-secondary">${escapeHtml(source)}</span>`;
    }

    async function requestJson(path, options = {}) {
      const res = await fetch(`${baseUrl}${path}`, options);
      let result;

      try {
        result = await res.json();
      } catch (e) {
        throw new Error(`Invalid JSON response from ${path}`);
      }

      if (!res.ok) {
        throw new Error(result?.message || `HTTP ${res.status}`);
      }

      return result;
    }

    /* ------------------------------------------------------------------ */
    /* Scrape Author                                                        */
    /* ------------------------------------------------------------------ */
    const btnScrapeAuthors = document.getElementById('btnScrapeAuthors');
    const originalAuthorsHtml = btnScrapeAuthors.innerHTML;

    btnScrapeAuthors.addEventListener('click', async function() {
      if (!confirm('Mulai scraping semua profil author dari SINTA?\nProses ini bisa memakan beberapa menit.')) return;

      setBtnLoading(btnScrapeAuthors, true, originalAuthorsHtml);
      try {
        await triggerScrape({
          source: 'sinta_authors'
        }, 'Authors');
      } finally {
        setBtnLoading(btnScrapeAuthors, false, originalAuthorsHtml);
      }
    });

    /* ------------------------------------------------------------------ */
    /* Scrape Articles                                                      */
    /* ------------------------------------------------------------------ */
    const btnScrapeArticles = document.getElementById('btnScrapeArticles');
    const originalArticlesHtml = btnScrapeArticles.innerHTML;
    const selectArticleAuthors = document.getElementById('selectArticleAuthors');
    const btnSelectAllAuthors = document.getElementById('btnSelectAllAuthors');
    const btnClearAllAuthors = document.getElementById('btnClearAllAuthors');

    btnSelectAllAuthors.addEventListener('click', function() {
      Array.from(selectArticleAuthors.options).forEach(opt => {
        opt.selected = true;
      });
    });

    btnClearAllAuthors.addEventListener('click', function() {
      Array.from(selectArticleAuthors.options).forEach(opt => {
        opt.selected = false;
      });
    });

    btnScrapeArticles.addEventListener('click', async function() {
      let payload = {
        source: 'sinta_articles'
      };

      const ids = Array.from(selectArticleAuthors.selectedOptions)
        .map(opt => parseInt(opt.value, 10))
        .filter(n => !isNaN(n) && n > 0);

      if (ids.length > 0) {
        payload.sinta_ids = ids;
      }

      const confirmMsg = payload.sinta_ids ?
        `Mulai scraping artikel untuk ${payload.sinta_ids.length} dosen terpilih?` :
        'Mulai scraping artikel untuk semua author di database backend?';

      if (!confirm(confirmMsg)) return;

      setBtnLoading(btnScrapeArticles, true, originalArticlesHtml);
      try {
        await triggerScrape(payload, 'Articles');
      } finally {
        setBtnLoading(btnScrapeArticles, false, originalArticlesHtml);
      }
    });

    /* ------------------------------------------------------------------ */
    /* Core: POST /scraping/triggerScraping                                 */
    /* ------------------------------------------------------------------ */
    async function triggerScrape(payload, label) {
      try {
        const result = await requestJson('scraping/triggerScraping', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload),
        });

        if (!result.success) {
          alert(`Gagal memulai ${label} scraping:\n${result.message}`);
          return;
        }

        currentJobId = result.job_id;
        document.getElementById('currentJobId').textContent = currentJobId;
        document.getElementById('jobSourceLabel').innerHTML = getSourceLabel(payload.source);

        showProgressSection();
        startMonitoring(currentJobId);
        loadJobs();

      } catch (err) {
        console.error('triggerScrape error:', err);
        alert(`Network error saat memulai ${label} scraping.`);
      }
    }

    /* ------------------------------------------------------------------ */
    /* Sync Authors: Open Preview Page                                      */
    /* ------------------------------------------------------------------ */
    const btnPreviewSync = document.getElementById('btnPreviewSync');
    btnPreviewSync.addEventListener('click', function() {
      window.location.href = `${baseUrl}scraping/previewSyncAuthorsPage`;
    });

    const btnSyncArticles = document.getElementById('btnSyncArticles');
    btnSyncArticles.addEventListener('click', function() {
      window.location.href = `${baseUrl}scraping/previewSyncArticlesPage`;
    });

    /* ------------------------------------------------------------------ */
    /* Progress Monitor                                                     */
    /* ------------------------------------------------------------------ */
    function showProgressSection() {
      const section = document.getElementById('progressSection');
      section.style.display = '';
      section.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });

      // Reset UI
      document.getElementById('progressBar').style.width = '0%';
      document.getElementById('progressPercentage').textContent = '0%';
      document.getElementById('cntTotal').textContent = '0';
      document.getElementById('cntProcessed').textContent = '0';
      document.getElementById('cntElapsed').textContent = '00:00:00';
      document.getElementById('cntRemaining').textContent = '—';
      document.getElementById('statusBadge').className = 'badge fs-6 bg-secondary';
      document.getElementById('statusBadge').textContent = 'PENDING';
    }

    function startMonitoring(jobId) {
      stopMonitoring();
      progressInterval = setInterval(() => updateProgress(jobId), 2500);
      updateProgress(jobId);
    }

    function stopMonitoring() {
      clearInterval(progressInterval);
      progressInterval = null;
    }

    document.getElementById('btnStopMonitor').addEventListener('click', function() {
      stopMonitoring();
      document.getElementById('progressSection').style.display = 'none';
    });


    /* ------------------------------------------------------------------ */
    /* Poll: Progress                                                       */
    /* ------------------------------------------------------------------ */
    async function updateProgress(jobId) {
      try {
        const result = await requestJson(`scraping/getJobProgress/${jobId}`);
        if (!result.success) return;

        const status = String(result.status || 'pending').toLowerCase();
        const progress = Number(result.progress_percentage || 0);
        const total = Number(result.total_records || 0);
        const processed = Number(result.processed_records || 0);

        document.getElementById('progressBar').style.width = `${Math.max(0, Math.min(100, progress))}%`;
        document.getElementById('progressPercentage').textContent = `${progress.toFixed(1)}%`;
        document.getElementById('cntTotal').textContent = total;
        document.getElementById('cntProcessed').textContent = processed;
        document.getElementById('cntElapsed').textContent = formatDuration(result.elapsed_seconds);
        document.getElementById('cntRemaining').textContent = formatDuration(result.estimated_remaining);

        const badge = document.getElementById('statusBadge');
        badge.className = `badge fs-6 ${STATUS_COLORS[status] ?? 'bg-secondary'}`;
        badge.textContent = status.toUpperCase();

        if (status === 'finished' || status === 'failed') {
          stopMonitoring();
          loadJobs(currentPage);
        }
      } catch (err) {
        console.error('updateProgress error:', err);
      }
    }

    /* ------------------------------------------------------------------ */
    /* Job History                                                          */
    /* ------------------------------------------------------------------ */
    async function loadJobs(page = 1) {
      currentPage = page;

      const status = document.getElementById('filterStatus').value;
      const source = document.getElementById('filterSource').value;

      let url = `${baseUrl}scraping/getJobs?page=${page}`;
      if (status) url += `&status=${status}`;
      if (source) url += `&source=${source}`;

      try {
        const res = await fetch(url);
        const result = await res.json();
        if (result.success) {
          renderJobs(result.data);
          renderPagination(result.meta.pagination);
        }
      } catch (err) {
        console.error('loadJobs error:', err);
      }
    }

    function renderJobs(jobs) {
      const tbody = document.getElementById('jobsTableBody');

      if (!jobs || jobs.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">Tidak ada job ditemukan.</td></tr>';
        return;
      }

      tbody.innerHTML = jobs.map(job => {
        const durationSec = job.started_at && job.finished_at ?
          Math.floor((new Date(job.finished_at) - new Date(job.started_at)) / 1000) :
          null;

        const sourceLabel = getSourceLabel(job.source);
        const jobId = String(job.job_id || '');
        const shortJobId = escapeHtml(jobId.substring(0, 8));

        return `
        <tr>
          <td><code class="small">${shortJobId}…</code></td>
          <td>${sourceLabel}</td>
          <td><span class="badge ${STATUS_COLORS[job.status] ?? 'bg-secondary'}">${escapeHtml(job.status)}</span></td>
          <td class="small">${formatTimestamp(job.created_at)}</td>
          <td class="small">${formatDuration(durationSec)}</td>
          <td class="small">${escapeHtml(job.processed_records)} / ${escapeHtml(job.total_records)}</td>
          <td>
            <button
              class="btn btn-sm btn-outline-primary btn-view-detail"
              data-job-id="${escapeHtml(jobId)}"
              title="Lihat Detail"
            >
              <i class="bi bi-eye"></i>
            </button>
            ${job.status === 'running' ? `
            <button
              class="btn btn-sm btn-outline-info btn-watch-job ms-1"
              data-job-id="${escapeHtml(jobId)}"
              data-source="${escapeHtml(job.source)}"
              title="Pantau Live"
            >
              <i class="bi bi-activity"></i>
            </button>` : ''}
          </td>
        </tr>
      `;
      }).join('');

      // Detail buttons
      document.querySelectorAll('.btn-view-detail').forEach(btn => {
        btn.addEventListener('click', function() {
          viewJobDetails(this.dataset.jobId);
        });
      });

      // Watch (live monitor) buttons
      document.querySelectorAll('.btn-watch-job').forEach(btn => {
        btn.addEventListener('click', function() {
          const jid = this.dataset.jobId;
          const src = this.dataset.source;
          currentJobId = jid;
          document.getElementById('currentJobId').textContent = jid;
          document.getElementById('jobSourceLabel').innerHTML = getSourceLabel(src);
          showProgressSection();
          startMonitoring(jid);
        });
      });
    }

    function renderPagination(pagination) {
      const nav = document.getElementById('pagination');
      const total = pagination.total_pages;
      const cur = pagination.page;

      if (!total || total <= 1) {
        nav.innerHTML = '';
        return;
      }

      let html = '';

      html += `<li class="page-item ${cur === 1 ? 'disabled' : ''}">
               <a class="page-link" href="#" data-page="${cur - 1}">«</a>
             </li>`;

      for (let i = 1; i <= total; i++) {
        if (i === 1 || i === total || (i >= cur - 2 && i <= cur + 2)) {
          html += `<li class="page-item ${i === cur ? 'active' : ''}">
                   <a class="page-link" href="#" data-page="${i}">${i}</a>
                 </li>`;
        } else if (i === cur - 3 || i === cur + 3) {
          html += `<li class="page-item disabled"><span class="page-link">…</span></li>`;
        }
      }

      html += `<li class="page-item ${cur === total ? 'disabled' : ''}">
               <a class="page-link" href="#" data-page="${cur + 1}">»</a>
             </li>`;

      nav.innerHTML = html;

      nav.querySelectorAll('a.page-link').forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          if (!this.closest('.disabled')) {
            loadJobs(parseInt(this.dataset.page, 10));
          }
        });
      });
    }

    /* ------------------------------------------------------------------ */
    /* Job Detail Modal                                                     */
    /* ------------------------------------------------------------------ */
    async function viewJobDetails(jobUuid) {
      const modal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
      const modalBody = document.getElementById('jobDetailBody');

      modalBody.innerHTML = '<div class="text-center py-4 text-muted"><div class="spinner-border me-2"></div>Loading…</div>';
      modal.show();

      try {
        const result = await requestJson(`scraping/getJobDetails/${jobUuid}`);

        if (!result.success) {
          modalBody.innerHTML = '<div class="alert alert-danger">Job tidak ditemukan.</div>';
          return;
        }

        const data = result.data;
        const job = data.job;
        const lc = data.log_counts;

        modalBody.innerHTML = `
        <div class="row g-3 mb-3">
          <div class="col-12">
            <div class="p-2 bg-light rounded small">
              <span class="text-muted">Job ID:</span>
              <code class="ms-1">${escapeHtml(job.job_id)}</code>
            </div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <div class="fw-semibold small text-muted mb-1">Source</div>
            ${getSourceLabel(job.source)}
          </div>
          <div class="col-6">
            <div class="fw-semibold small text-muted mb-1">Status</div>
            <span class="badge ${STATUS_COLORS[job.status] ?? 'bg-secondary'}">${escapeHtml(job.status)}</span>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-6">
            <div class="fw-semibold small text-muted mb-1">Progress</div>
            <div>${(data.progress_percentage ?? 0).toFixed(1)}%
              <span class="text-muted small">(${job.processed_records} / ${job.total_records})</span>
            </div>
          </div>
          <div class="col-6">
            <div class="fw-semibold small text-muted mb-1">Duration</div>
            <div>${data.duration ?? '—'}</div>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-4">
            <div class="fw-semibold small text-muted mb-1">Created</div>
            <div class="small">${formatTimestamp(job.created_at)}</div>
          </div>
          <div class="col-4">
            <div class="fw-semibold small text-muted mb-1">Started</div>
            <div class="small">${formatTimestamp(job.started_at)}</div>
          </div>
          <div class="col-4">
            <div class="fw-semibold small text-muted mb-1">Finished</div>
            <div class="small">${formatTimestamp(job.finished_at)}</div>
          </div>
        </div>

        <div class="mb-3">
          <div class="fw-semibold small text-muted mb-2">Log Summary</div>
          <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-secondary">DEBUG: ${lc.DEBUG  ?? 0}</span>
            <span class="badge bg-info text-dark">INFO: ${lc.INFO ?? 0}</span>
            <span class="badge bg-warning text-dark">WARNING: ${lc.WARNING ?? 0}</span>
            <span class="badge bg-danger">ERROR: ${lc.ERROR ?? 0}</span>
          </div>
        </div>

        <div class="mb-3">
          <div class="fw-semibold small text-muted mb-2">Log Stream</div>
          <div class="border rounded p-3 bg-dark text-light" style="max-height:320px;overflow-y:auto;font-family:'Courier New',monospace;font-size:0.82rem;">
            ${(data.logs && data.logs.length)
              ? data.logs.map(log => {
                const ts = log.created_at ? new Date(log.created_at).toLocaleString('id-ID') : '-';
                const level = escapeHtml(log.level ?? 'INFO');
                const message = escapeHtml(log.message ?? '');
                return `<div class="mb-1">[${ts}] [${level}] ${message}</div>`;
              }).join('')
              : '<div class="text-muted">Tidak ada log untuk job ini.</div>'
            }
          </div>
        </div>

        ${job.parameters ? `
        <div class="mb-3">
          <div class="fw-semibold small text-muted mb-1">Parameters</div>
          <pre class="bg-light rounded p-2 small mb-0" style="font-size:0.78rem;">${JSON.stringify(job.parameters, null, 2)}</pre>
        </div>` : ''}

        ${job.error_message ? `
        <div class="alert alert-danger mb-0">
          <i class="bi bi-exclamation-triangle-fill me-1"></i>
          <strong>Error:</strong> ${escapeHtml(job.error_message)}
        </div>` : ''}
      `;

      } catch (err) {
        console.error('viewJobDetails error:', err);
        modalBody.innerHTML = '<div class="alert alert-danger">Gagal memuat detail job.</div>';
      }
    }

    /* ------------------------------------------------------------------ */
    /* Event Listeners & Init                                               */
    /* ------------------------------------------------------------------ */
    document.getElementById('btnRefreshJobs').addEventListener('click', () => loadJobs(currentPage));
    document.getElementById('btnApplyFilter').addEventListener('click', () => loadJobs(1));
    document.getElementById('filterStatus').addEventListener('change', () => loadJobs(1));
    document.getElementById('filterSource').addEventListener('change', () => loadJobs(1));

    // Initial load
    loadJobs();

  }); // end DOMContentLoaded
</script>