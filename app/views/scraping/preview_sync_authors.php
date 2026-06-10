<!-- Page-specific styles for consistent design -->
<style>
  /* Reuse scraping page design system */
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

  .preview-page-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .preview-page-header h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .preview-page-header h4 i {
    color: var(--scrape-primary);
  }

  .preview-card {
    background: #ffffff;
    border-radius: var(--scrape-radius);
    box-shadow: var(--scrape-card-shadow);
    border: 1px solid var(--scrape-border);
    overflow: hidden;
  }

  .preview-card-body {
    padding: 1.5rem;
  }

  .preview-stats {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
  }

  .preview-stat-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.8125rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
  }

  .preview-stat-badge.insert {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .preview-stat-badge.update {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .preview-stat-badge.skip {
    background: #f1f5f9;
    color: #475569;
  }

  .preview-stat-badge.total {
    background: #1e293b;
    color: #ffffff;
  }

  .preview-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
  }

  .preview-table thead th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--scrape-muted);
    border-bottom: 1px solid var(--scrape-border);
    position: sticky;
    top: 0;
    z-index: 1;
  }

  .preview-table tbody td {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    border-bottom: 1px solid var(--scrape-border);
    vertical-align: middle;
  }

  .preview-table tbody tr:hover {
    background: #f8fafc;
  }

  .preview-table tbody tr:last-child td {
    border-bottom: none;
  }

  .preview-type-badge {
    padding: 0.25rem 0.5rem;
    border-radius: var(--scrape-radius-sm);
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
  }

  .preview-type-badge.insert {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .preview-type-badge.update {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .preview-change-tag {
    display: inline-flex;
    padding: 0.125rem 0.5rem;
    background: #f8fafc;
    border: 1px solid var(--scrape-border);
    border-radius: 4px;
    font-size: 0.75rem;
    color: #475569;
    margin: 0.125rem;
  }

  .preview-empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--scrape-muted);
  }

  .preview-empty-state i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 0.75rem;
    color: var(--scrape-success);
  }

  .preview-empty-state p {
    margin: 0;
    font-size: 0.9375rem;
  }

  .preview-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
  }

  .preview-btn {
    padding: 0.625rem 1.25rem;
    border-radius: var(--scrape-radius-sm);
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
    text-decoration: none;
    border: 1px solid transparent;
  }

  .preview-btn.secondary {
    background: #f1f5f9;
    color: #475569;
    border-color: var(--scrape-border);
  }

  .preview-btn.secondary:hover {
    background: #e2e8f0;
    color: #1e293b;
  }

  .preview-btn.confirm {
    background: var(--scrape-warning);
    color: #ffffff;
    border-color: var(--scrape-warning);
  }

  .preview-btn.confirm:hover {
    background: #b45309;
    border-color: #b45309;
  }

  .preview-btn.confirm:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .preview-alert {
    padding: 0.75rem 1rem;
    border-radius: var(--scrape-radius-sm);
    font-size: 0.875rem;
    margin-bottom: 1rem;
  }

  .preview-alert.info {
    background: var(--scrape-primary-light);
    color: var(--scrape-primary);
  }

  .preview-alert.success {
    background: var(--scrape-success-light);
    color: var(--scrape-success);
  }

  .preview-alert.danger {
    background: var(--scrape-danger-light);
    color: var(--scrape-danger);
  }

  .table-container {
    border: 1px solid var(--scrape-border);
    border-radius: var(--scrape-radius-sm);
    max-height: 600px;
    overflow-y: auto;
  }
</style>

<div class="container py-4" style="max-width: 1400px;">

  <!-- Page Header -->
  <div class="preview-page-header">
    <div>
      <h4><i class="bi bi-people"></i>Preview Sync Authors</h4>
      <p class="text-muted small mb-0">Ringkasan perubahan data author sebelum sinkronisasi ke database lokal.</p>
    </div>
    <a href="<?php echo BASE_URL; ?>scraping" class="preview-btn secondary">
      <i class="bi bi-arrow-left"></i>
      Kembali
    </a>
  </div>

  <!-- Preview Card -->
  <div class="preview-card">
    <div class="preview-card-body">

      <!-- Stats -->
      <div class="preview-stats">
        <span class="preview-stat-badge insert">
          <i class="bi bi-plus-circle"></i>
          Insert: <?php echo count($inserted ?? []); ?>
        </span>
        <span class="preview-stat-badge update">
          <i class="bi bi-pencil"></i>
          Update: <?php echo count($updated ?? []); ?>
        </span>
        <span class="preview-stat-badge skip">
          <i class="bi bi-dash-circle"></i>
          Skip: <?php echo (int) (($stats['skipped'] ?? 0)); ?>
        </span>
        <span class="preview-stat-badge total">
          <i class="bi bi-collection"></i>
          Total: <?php echo (int) (($stats['total'] ?? 0)); ?>
        </span>
      </div>

      <?php $skippedList = $skipped_details ?? []; ?>
      <?php if (!empty($skippedList)): ?>
      <!-- Skipped Details Toggle -->
      <div class="mb-3">
        <button type="button" class="preview-btn secondary" data-bs-toggle="collapse" data-bs-target="#skippedDetails" aria-expanded="false" aria-controls="skippedDetails">
          <i class="bi bi-eye"></i> Detail author yang di-skip (<?php echo count($skippedList); ?>)
        </button>
        <div class="collapse mt-2" id="skippedDetails">
          <div class="table-container">
            <table class="preview-table">
              <thead>
                <tr>
                  <th style="width: 50px;">No</th>
                  <th>Nama</th>
                  <th style="width: 180px;">ID SINTA</th>
                  <th style="width: 280px;">Alasan di-skip</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($skippedList as $idx => $item): ?>
                  <tr>
                    <td><?php echo $idx + 1; ?></td>
                    <td><?php echo htmlspecialchars((string) ($item['fullname'] ?? '-')); ?></td>
                    <td class="text-muted"><?php echo htmlspecialchars((string) (is_null($item['id_sinta'] ?? null) ? 'null' : var_export($item['id_sinta'], true))); ?></td>
                    <td><span class="preview-change-tag"><?php echo htmlspecialchars((string) ($item['reason'] ?? '-')); ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div id="syncAlert" class="preview-alert d-none"></div>

      <?php $hasChanges = !empty($inserted) || !empty($updated); ?>

      <?php if (!$hasChanges): ?>
        <!-- Empty State -->
        <div class="preview-empty-state">
          <i class="bi bi-check-circle-fill"></i>
          <p>Data authors di database lokal sudah up-to-date.<br>Tidak ada perubahan yang perlu disinkronkan.</p>
        </div>
      <?php else: ?>
        <!-- Changes Table -->
        <div class="table-container">
          <table class="preview-table">
            <thead>
              <tr>
                <th style="width: 90px;">Type</th>
                <th>Nama &amp; SINTA ID</th>
                <th style="width: 300px;">Perubahan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (($inserted ?? []) as $author): ?>
                <tr>
                  <td>
                    <span class="preview-type-badge insert">
                      <i class="bi bi-plus-lg"></i>INSERT
                    </span>
                  </td>
                  <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars((string) ($author['fullname'] ?? $author['nama'] ?? '-')); ?></div>
                    <div class="small text-muted">NIDN: <?php echo htmlspecialchars((string) ($author['nidn'] ?? '-')); ?> | ID: <?php echo htmlspecialchars((string) ($author['id_sinta'] ?? '-')); ?></div>
                  </td>
                  <td>
                    <span class="small text-muted">Author baru akan ditambahkan ke tabel <code>authors</code>.</span>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php foreach (($updated ?? []) as $author): ?>
                <tr>
                  <td>
                    <span class="preview-type-badge update">
                      <i class="bi bi-pencil"></i>UPDATE
                    </span>
                  </td>
                  <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars((string) ($author['fullname'] ?? '-')); ?></div>
                    <div class="small text-muted">NIDN: <?php echo htmlspecialchars((string) ($author['nidn'] ?? '-')); ?> | ID: <?php echo htmlspecialchars((string) ($author['id_sinta'] ?? '-')); ?></div>
                  </td>
                  <td>
                    <?php if (!empty($author['changes']) && is_array($author['changes'])): ?>
                      <div class="d-flex flex-wrap gap-1 mb-1">
                        <?php foreach ($author['changes'] as $change): ?>
                          <span class="preview-change-tag"><?php echo htmlspecialchars((string) ($change['label'] ?? $change['field'] ?? '-')); ?></span>
                        <?php endforeach; ?>
                      </div>
                      <div class="small text-muted">
                        <?php foreach ($author['changes'] as $change): ?>
                          <div>
                            <strong><?php echo htmlspecialchars((string) ($change['label'] ?? $change['field'] ?? '-')); ?>:</strong>
                            <?php echo htmlspecialchars((string) (($change['old'] ?? null) === null ? '-' : $change['old'])); ?>
                            <i class="bi bi-arrow-right mx-1"></i>
                            <?php echo htmlspecialchars((string) (($change['new'] ?? null) === null ? '-' : $change['new'])); ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    <?php else: ?>
                      <span class="text-muted small">Tidak ada detail perubahan.</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <!-- Actions -->
      <div class="preview-actions">
        <a href="<?php echo BASE_URL; ?>scraping" class="preview-btn secondary">
          <i class="bi bi-x-lg"></i>
          Batal
        </a>
        <button type="button" class="preview-btn confirm" id="btnExecuteSync" <?php echo $hasChanges ? '' : 'disabled'; ?>>
          <i class="bi bi-database-fill-up"></i>
          Confirm Sync
        </button>
      </div>

    </div>
  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = '<?php echo BASE_URL; ?>';
    const btnExecute = document.getElementById('btnExecuteSync');
    const syncAlert = document.getElementById('syncAlert');

    const payload = {
      inserted: <?php echo json_encode($inserted ?? []); ?>,
      updated: <?php echo json_encode($updated ?? []); ?>,
    };

    function setBtnLoading(btn, loading, originalHtml) {
      btn.disabled = loading;
      btn.innerHTML = loading ?
        '<span class="spinner-border spinner-border-sm me-1"></span>Processing...' :
        originalHtml;
    }

    function showAlert(type, message) {
      syncAlert.className = `preview-alert ${type}`;
      syncAlert.textContent = message;
      syncAlert.classList.remove('d-none');
    }

    if (!btnExecute) return;
    const originalHtml = btnExecute.innerHTML;

    btnExecute.addEventListener('click', async function() {
      if (!payload.inserted.length && !payload.updated.length) {
        return;
      }

      if (!confirm(`Eksekusi sinkronisasi sekarang?\nInsert: ${payload.inserted.length}\nUpdate: ${payload.updated.length}`)) {
        return;
      }

      setBtnLoading(btnExecute, true, originalHtml);

      try {
        const res = await fetch(`${baseUrl}scraping/executeSyncAuthors`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        const result = await res.json();

        if (!res.ok || !result.success) {
          showAlert('danger', result.message || 'Gagal mengeksekusi sync.');
          return;
        }

        showAlert('success', result.message || 'Sync berhasil dijalankan.');
        btnExecute.disabled = true;
        btnExecute.classList.add('disabled');
      } catch (err) {
        console.error('executeSync error:', err);
        showAlert('danger', 'Network error saat mengeksekusi sync.');
      } finally {
        setBtnLoading(btnExecute, false, originalHtml);
      }
    });
  });
</script>