<!-- Page-specific styles for consistent design -->
<style>
  /* ============================================
     SCRAPING PAGE DESIGN SYSTEM
     ============================================ */

  /* CSS Custom Properties */
  :root {
    --scrape-primary: #0066cc;
    --scrape-primary-hover: #0056b3;
    --scrape-primary-light: #e6f2ff;
    --scrape-success: #16a34a;
    --scrape-success-light: #dcfce7;
    --scrape-warning: #d97706;
    --scrape-warning-light: #fef3c7;
    --scrape-danger: #dc2626;
    --scrape-danger-light: #fee2e2;
    --scrape-muted: #64748b;
    --scrape-border: #e2e8f0;
    --scrape-card-shadow: 0 1px 3px rgba(0, 0, 0, 0.08), 0 1px 2px rgba(0, 0, 0, 0.04);
    --scrape-radius: 12px;
    --scrape-radius-sm: 8px;
  }

  /* Section Title */
  .scrape-section-title {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--scrape-muted);
    margin-bottom: 1rem;
  }

  /* Action Card Base */
  .scrape-action-card {
    background: #ffffff;
    border-radius: var(--scrape-radius);
    box-shadow: var(--scrape-card-shadow);
    border: 1px solid var(--scrape-border);
    overflow: hidden;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .scrape-action-card:hover {
    box-shadow: 0 4px 12px rgba(0, 102, 204, 0.1);
  }

  /* Card Header */
  .scrape-card-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--scrape-border);
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }

  .scrape-card-header .header-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--scrape-radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
  }

  .scrape-card-header .header-icon.primary {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .scrape-card-header .header-icon.success {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .scrape-card-header .header-icon.warning {
    background: var(--scrape-warning-light);
    color: var(--scrape-warning);
  }

  .scrape-card-header .header-text h6 {
    font-size: 0.9375rem;
    font-weight: 600;
    margin: 0;
    color: #1e293b;
  }

  .scrape-card-header .header-text small {
    font-size: 0.75rem;
    color: var(--scrape-muted);
  }

  /* Card Body */
  .scrape-card-body {
    padding: 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }

  .scrape-card-body p {
    font-size: 0.875rem;
    color: #475569;
    line-height: 1.6;
  }

  .scrape-card-body code {
    background: #f1f5f9;
    padding: 0.125rem 0.375rem;
    border-radius: 4px;
    font-size: 0.8125rem;
    color: #334155;
  }

  /* Action Buttons */
  .scrape-btn-action {
    width: 100%;
    padding: 0.625rem 1rem;
    border-radius: var(--scrape-radius-sm);
    font-weight: 500;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    border: 1px solid transparent;
  }

  .scrape-btn-action.primary {
    background: var(--scrape-primary);
    color: #ffffff;
    border-color: var(--scrape-primary);
  }

  .scrape-btn-action.primary:hover {
    background: var(--scrape-primary-hover);
    border-color: var(--scrape-primary-hover);
  }

  .scrape-btn-action.success {
    background: var(--scrape-success);
    color: #ffffff;
    border-color: var(--scrape-success);
  }

  .scrape-btn-action.success:hover {
    background: #15803d;
    border-color: #15803d;
  }

  .scrape-btn-action.outline {
    background: transparent;
    color: var(--scrape-primary);
    border-color: var(--scrape-primary);
  }

  .scrape-btn-action.outline:hover {
    background: var(--scrape-primary-light);
  }

  .scrape-btn-action.outline-secondary {
    background: transparent;
    color: var(--scrape-muted);
    border-color: var(--scrape-border);
  }

  .scrape-btn-action.outline-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
  }

  /* Select Styling */
  .scrape-select {
    border-radius: var(--scrape-radius-sm);
    border-color: var(--scrape-border);
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  .scrape-select:focus {
    border-color: var(--scrape-primary);
    box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
  }

  /* Status Badges */
  .scrape-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .scrape-badge.pending {
    background: #f1f5f9;
    color: #475569;
  }

  .scrape-badge.running {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .scrape-badge.finished {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .scrape-badge.failed {
    background: var(--scrape-danger-light);
    color: var(--scrape-danger);
  }

  /* Source Badges */
  .scrape-badge.source-authors {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .scrape-badge.source-articles {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .scrape-badge.source-both {
    background: #f1f5f9;
    color: #334155;
  }

  /* History Table */
  .scrape-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .scrape-table thead th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--scrape-muted);
    border-bottom: 1px solid var(--scrape-border);
  }

  .scrape-table tbody td {
    padding: 0.875rem 1rem;
    font-size: 0.875rem;
    border-bottom: 1px solid var(--scrape-border);
    vertical-align: middle;
  }

  .scrape-table tbody tr:hover {
    background: #f8fafc;
  }

  .scrape-table tbody tr:last-child td {
    border-bottom: none;
  }

  /* Table Action Button */
  .scrape-btn-icon {
    width: 32px;
    height: 32px;
    border-radius: var(--scrape-radius-sm);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border: 1px solid var(--scrape-border);
    color: var(--scrape-muted);
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .scrape-btn-icon:hover {
    background: var(--scrape-primary-light);
    border-color: var(--scrape-primary);
    color: var(--scrape-primary);
  }

  /* Filter Controls */
  .scrape-filter-group {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
  }

  /* Modal Styling */
  .scrape-modal-header {
    background: var(--scrape-primary);
    color: #ffffff;
    border-bottom: none;
    padding: 1rem 1.5rem;
  }

  .scrape-modal-header .btn-close-white {
    opacity: 0.8;
  }

  .scrape-modal-header .btn-close-white:hover {
    opacity: 1;
  }

  /* Alert Styling */
  .scrape-alert {
    padding: 0.75rem 1rem;
    border-radius: var(--scrape-radius-sm);
    font-size: 0.875rem;
    border: 1px solid;
  }

  .scrape-alert.info {
    background: var(--scrape-primary-light);
    border-color: #b3d7ff;
    color: var(--scrape-primary);
  }

  .scrape-alert.success {
    background: var(--scrape-success-light);
    border-color: #bbf7d0;
    color: var(--scrape-success);
  }

  .scrape-alert.warning {
    background: var(--scrape-warning-light);
    border-color: #fde68a;
    color: var(--scrape-warning);
  }

  .scrape-alert.danger {
    background: var(--scrape-danger-light);
    border-color: #fecaca;
    color: var(--scrape-danger);
  }

  /* Progress indicator */
  .scrape-progress {
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
    overflow: hidden;
  }

  .scrape-progress-bar {
    height: 100%;
    border-radius: 3px;
    background: var(--scrape-primary);
    transition: width 0.3s ease;
  }

  /* Job ID code styling */
  .scrape-job-id {
    font-family: 'Fira Code', 'Consolas', monospace;
    font-size: 0.8125rem;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    color: #334155;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .scrape-action-card {
      margin-bottom: 1rem;
    }

    .scrape-filter-group {
      width: 100%;
    }

    .scrape-filter-group .scrape-select {
      flex: 1;
      min-width: 0;
    }
  }
</style>

<div class="container py-4" style="max-width: 1400px;">

  <!-- Page Header -->
  <div class="mb-4">
    <h4 class="fw-bold mb-1">Scraping Management</h4>
    <p class="text-muted small mb-0">Kelola data scraping dan sinkronisasi dari SINTA</p>
  </div>

  <!-- Action Cards Section -->
  <div class="scrape-section-title">Actions</div>
  <div class="row g-3 mb-4">

    <!-- Card 1: Scrape Authors -->
    <div class="col-lg-4 col-md-6">
      <div class="scrape-action-card">
        <div class="scrape-card-header">
          <div class="header-icon primary">
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="header-text">
            <h6>Scrape Authors</h6>
            <small>Profil dosen dari SINTA</small>
          </div>
        </div>
        <div class="scrape-card-body">
          <p class="mb-3">
            Ambil profil dan bibliometrik semua dosen dari halaman afiliasi SINTA
            (ID: 528 / UNIKOM). Proses terjadi dalam dua fase: list afiliasi lalu detail per profil.
          </p>
          <div class="mt-auto">
            <button type="button" class="scrape-btn-action primary" id="btnScrapeAuthors">
              <i class="bi bi-arrow-down-circle"></i>
              Start Scraping
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Scrape Articles -->
    <div class="col-lg-4 col-md-6">
      <div class="scrape-action-card">
        <div class="scrape-card-header">
          <div class="header-icon success">
            <i class="bi bi-journal-text"></i>
          </div>
          <div class="header-text">
            <h6>Scrape Articles</h6>
            <small>Artikel dari 4 sumber</small>
          </div>
        </div>
        <div class="scrape-card-body">
          <p class="mb-2">
            Ambil artikel dari 4 view SINTA (Scopus, Garuda, GScholar, RAMA)
            untuk author tertentu atau seluruh author di database.
          </p>
          <div class="mb-3">
            <label class="form-label small fw-semibold mb-1">
              Pilih Dosen <span class="text-muted fw-normal">(opsional)</span>
            </label>
            <select class="form-select scrape-select" id="selectArticleAuthors" multiple size="5">
              <?php foreach (($authorsForScrape ?? []) as $author): ?>
                <option value="<?php echo (int) $author['id_sinta']; ?>">
                  <?php echo htmlspecialchars($author['fullname']); ?> (ID: <?php echo (int) $author['id_sinta']; ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <div class="d-flex gap-2 mt-2">
              <button type="button" class="scrape-btn-action outline-secondary" id="btnSelectAllAuthors" style="width: auto; padding: 0.375rem 0.75rem;">
                Pilih Semua
              </button>
              <button type="button" class="scrape-btn-action outline-secondary" id="btnClearAllAuthors" style="width: auto; padding: 0.375rem 0.75rem;">
                Kosongkan
              </button>
            </div>
          </div>
          <div class="mt-auto">
            <button type="button" class="scrape-btn-action success" id="btnScrapeArticles">
              <i class="bi bi-arrow-down-circle"></i>
              Start Scraping
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Sync to Local DB -->
    <div class="col-lg-4 col-md-6">
      <div class="scrape-action-card">
        <div class="scrape-card-header">
          <div class="header-icon warning">
            <i class="bi bi-arrow-repeat"></i>
          </div>
          <div class="header-text">
            <h6>Sync Database</h6>
            <small>Sinkronisasi ke database lokal</small>
          </div>
        </div>
        <div class="scrape-card-body">
          <p class="mb-3">
            Tarik data <code>sinta_authors</code> dan <code>sinta_articles</code> dari KP-Backend
            lalu cocokkan dengan tabel lokal. Record yang berubah akan diupdate; record baru akan diinsert.
          </p>
          <div id="syncResult" class="scrape-alert info d-none mb-3"></div>
          <div id="syncArticleResult" class="scrape-alert info d-none mb-3"></div>
          <div class="mt-auto d-flex flex-column gap-2">
            <button type="button" class="scrape-btn-action outline" id="btnPreviewSync">
              <i class="bi bi-search"></i>
              Preview Sync Authors
            </button>
            <button type="button" class="scrape-btn-action outline" id="btnSyncArticles">
              <i class="bi bi-journal-check"></i>
              Preview Sync Articles
            </button>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /action cards -->

  <!-- Job History Section -->
  <div class="scrape-section-title">Job History</div>
  <div class="scrape-action-card" style="overflow: visible;">
    <div class="scrape-card-header" style="border-bottom: 1px solid var(--scrape-border);">
      <div class="d-flex justify-content-between align-items-center w-100">
        <h6 class="mb-0 fw-semibold">Scraping Jobs</h6>
        <button class="scrape-btn-icon" id="btnRefreshJobs" title="Refresh">
          <i class="bi bi-arrow-clockwise"></i>
        </button>
      </div>
    </div>
    <div class="scrape-card-body" style="padding: 0;">

      <!-- Filters -->
      <div class="p-3 border-bottom" style="border-color: var(--scrape-border) !important;">
        <div class="scrape-filter-group">
          <select class="form-select scrape-select" id="filterStatus" style="width: 150px;">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="running">Running</option>
            <option value="finished">Finished</option>
            <option value="failed">Failed</option>
          </select>
          <select class="form-select scrape-select" id="filterSource" style="width: 150px;">
            <option value="">Semua Source</option>
            <option value="sinta_authors">Authors</option>
            <option value="sinta_articles">Articles</option>
            <option value="both">Both</option>
          </select>
        </div>
      </div>

      <!-- Table -->
      <div class="table-responsive">
        <table class="scrape-table">
          <thead>
            <tr>
              <th>Job ID</th>
              <th>Source</th>
              <th>Status</th>
              <th>Created</th>
              <th>Duration</th>
              <th>Records</th>
              <th style="width: 60px;">Aksi</th>
            </tr>
          </thead>
          <tbody id="jobsTableBody">
            <tr>
              <td colspan="7" class="text-center py-5">
                <div class="d-flex flex-column align-items-center gap-2">
                  <div class="spinner-border spinner-border-sm text-primary"></div>
                  <span class="text-muted small">Memuat data...</span>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="p-3 border-top" style="border-color: var(--scrape-border) !important;">
        <nav aria-label="Job pagination">
          <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
        </nav>
      </div>

    </div>
  </div>

</div><!-- /container -->

<!-- Job Detail Modal -->
<div class="modal fade" id="jobDetailModal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content" style="border-radius: var(--scrape-radius); overflow: hidden;">
      <div class="modal-header scrape-modal-header">
        <h5 class="modal-title" id="jobDetailModalLabel">
          <i class="bi bi-info-circle me-2"></i>Job Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0" id="jobDetailBody">
        <div class="text-center py-5 text-muted">
          <div class="spinner-border me-2"></div>Loading...
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    const baseUrl = '<?php echo BASE_URL; ?>';

    /* State */
    let currentPage = 1;

    /* Constants */
    const STATUS_CONFIG = {
      pending: { class: 'pending', icon: 'bi-clock' },
      running: { class: 'running', icon: 'bi-arrow-repeat' },
      finished: { class: 'finished', icon: 'bi-check-circle' },
      failed: { class: 'failed', icon: 'bi-x-circle' },
    };

    const SOURCE_CONFIG = {
      sinta_authors: { class: 'source-authors', label: 'Authors' },
      sinta_articles: { class: 'source-articles', label: 'Articles' },
      both: { class: 'source-both', label: 'Both' },
    };

    /* Helpers */
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
        '<span class="spinner-border spinner-border-sm me-1"></span>Processing...' :
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

    function getStatusBadge(status) {
      const config = STATUS_CONFIG[status] || { class: 'pending', icon: 'bi-question' };
      return `<span class="scrape-badge ${config.class}">
        <i class="bi ${config.icon}"></i>
        ${escapeHtml(status)}
      </span>`;
    }

    function getSourceBadge(source) {
      const config = SOURCE_CONFIG[source] || { class: 'source-both', label: source };
      return `<span class="scrape-badge ${config.class}">${escapeHtml(config.label)}</span>`;
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

    /* Scrape Author */
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

    /* Scrape Articles */
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

    /* Core: POST /scraping/triggerScraping */
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

        alert(`${label} scraping started!\nJob ID: ${result.job_id}\n\nRefresh halaman untuk melihat progress.`);
        loadJobs();

      } catch (err) {
        console.error('triggerScrape error:', err);
        alert(`Network error saat memulai ${label} scraping.`);
      }
    }

    /* Sync Authors: Open Preview Page */
    const btnPreviewSync = document.getElementById('btnPreviewSync');
    btnPreviewSync.addEventListener('click', function() {
      window.location.href = `${baseUrl}scraping/previewSyncAuthorsPage`;
    });

    const btnSyncArticles = document.getElementById('btnSyncArticles');
    btnSyncArticles.addEventListener('click', function() {
      window.location.href = `${baseUrl}scraping/previewSyncArticlesPage`;
    });

    /* Job History */
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
        tbody.innerHTML = `
          <tr>
            <td colspan="7" class="text-center py-5">
              <div class="text-muted">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                <span>Tidak ada job ditemukan</span>
              </div>
            </td>
          </tr>`;
        return;
      }

      tbody.innerHTML = jobs.map(job => {
        const durationSec = job.started_at && job.finished_at ?
          Math.floor((new Date(job.finished_at) - new Date(job.started_at)) / 1000) :
          null;

        const jobId = String(job.job_id || '');
        const shortJobId = escapeHtml(jobId.substring(0, 8));

        const progressPercent = job.total_records > 0
          ? Math.round((job.processed_records / job.total_records) * 100)
          : 0;

        return `
        <tr>
          <td><span class="scrape-job-id">${shortJobId}...</span></td>
          <td>${getSourceBadge(job.source)}</td>
          <td>${getStatusBadge(job.status)}</td>
          <td class="small text-muted">${formatTimestamp(job.created_at)}</td>
          <td class="small">${formatDuration(durationSec)}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <span class="small">${escapeHtml(job.processed_records)} / ${escapeHtml(job.total_records)}</span>
              ${job.status === 'running' ? `
                <div class="scrape-progress" style="width: 60px;">
                  <div class="scrape-progress-bar" style="width: ${progressPercent}%;"></div>
                </div>
              ` : ''}
            </div>
          </td>
          <td>
            <button
              class="scrape-btn-icon btn-view-detail"
              data-job-id="${escapeHtml(jobId)}"
              title="Lihat Detail"
            >
              <i class="bi bi-eye"></i>
            </button>
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
          html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
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

    /* Job Detail Modal */
    async function viewJobDetails(jobUuid) {
      const modal = new bootstrap.Modal(document.getElementById('jobDetailModal'));
      const modalBody = document.getElementById('jobDetailBody');

      modalBody.innerHTML = `
        <div class="text-center py-5 text-muted">
          <div class="spinner-border me-2"></div>Loading...
        </div>`;
      modal.show();

      try {
        const result = await requestJson(`scraping/getJobDetails/${jobUuid}`);

        if (!result.success) {
          modalBody.innerHTML = `
            <div class="p-4">
              <div class="scrape-alert danger">Job tidak ditemukan.</div>
            </div>`;
          return;
        }

        const data = result.data;
        const job = data.job;

        modalBody.innerHTML = `
        <div class="p-4">
          <!-- Job ID -->
          <div class="mb-4 p-3 rounded" style="background: #f8fafc;">
            <span class="text-muted small">Job ID</span>
            <div class="scrape-job-id mt-1">${escapeHtml(job.job_id)}</div>
          </div>

          <!-- Grid Info -->
          <div class="row g-3 mb-4">
            <div class="col-6">
              <div class="small text-muted mb-1">Source</div>
              ${getSourceBadge(job.source)}
            </div>
            <div class="col-6">
              <div class="small text-muted mb-1">Status</div>
              ${getStatusBadge(job.status)}
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-6">
              <div class="small text-muted mb-1">Progress</div>
              <div class="fw-semibold">${(data.progress_percentage ?? 0).toFixed(1)}%</div>
              <div class="small text-muted">${job.processed_records} / ${job.total_records} records</div>
              <div class="scrape-progress mt-2">
                <div class="scrape-progress-bar" style="width: ${data.progress_percentage ?? 0}%;"></div>
              </div>
            </div>
            <div class="col-6">
              <div class="small text-muted mb-1">Duration</div>
              <div class="fw-semibold">${data.duration ?? '—'}</div>
            </div>
          </div>

          <!-- Timestamps -->
          <div class="row g-3 mb-4">
            <div class="col-4">
              <div class="small text-muted mb-1">Created</div>
              <div class="small">${formatTimestamp(job.created_at)}</div>
            </div>
            <div class="col-4">
              <div class="small text-muted mb-1">Started</div>
              <div class="small">${formatTimestamp(job.started_at)}</div>
            </div>
            <div class="col-4">
              <div class="small text-muted mb-1">Finished</div>
              <div class="small">${formatTimestamp(job.finished_at)}</div>
            </div>
          </div>

          ${job.parameters ? `
          <div class="mb-4">
            <div class="small text-muted mb-2">Parameters</div>
            <pre class="p-3 rounded mb-0 small" style="background: #f8fafc; font-size: 0.8125rem; overflow-x: auto;">${JSON.stringify(job.parameters, null, 2)}</pre>
          </div>` : ''}

          ${job.error_message ? `
          <div class="scrape-alert danger">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Error:</strong> ${escapeHtml(job.error_message)}
          </div>` : ''}
        </div>
      `;

      } catch (err) {
        console.error('viewJobDetails error:', err);
        modalBody.innerHTML = `
          <div class="p-4">
            <div class="scrape-alert danger">Gagal memuat detail job.</div>
          </div>`;
      }
    }

    /* Event Listeners & Init */
    document.getElementById('btnRefreshJobs').addEventListener('click', () => loadJobs(currentPage));
    document.getElementById('filterStatus').addEventListener('change', () => loadJobs(1));
    document.getElementById('filterSource').addEventListener('change', () => loadJobs(1));

    // Initial load
    loadJobs();

  }); // end DOMContentLoaded
</script>