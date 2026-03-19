<div class="container py-4" style="max-width: 1400px;">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div>
      <h2 class="fw-bold mb-1">
        <i class="bi bi-search me-2"></i>Preview Sync Authors
      </h2>
      <p class="text-muted mb-0">Ringkasan perubahan data author sebelum sinkronisasi ke database lokal.</p>
    </div>
    <a href="<?php echo BASE_URL; ?>scraping" class="btn btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
    </a>
  </div>

  <div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex gap-2 flex-wrap mb-3">
        <span class="badge bg-primary">New (Insert): <?php echo count($inserted ?? []); ?></span>
        <span class="badge bg-success">Changed (Update): <?php echo count($updated ?? []); ?></span>
        <span class="badge bg-secondary border text-white">Unchanged (Skip): <?php echo (int) (($stats['skipped'] ?? 0)); ?></span>
        <span class="badge bg-dark border text-white">Total: <?php echo (int) (($stats['total'] ?? 0)); ?></span>
      </div>

      <div id="syncAlert" class="alert d-none py-2 small mb-3"></div>

      <?php $hasChanges = !empty($inserted) || !empty($updated); ?>
      <?php if (!$hasChanges): ?>
        <div class="alert alert-info py-3 text-center mb-0">
          <i class="bi bi-check-circle fs-4 d-block mb-2"></i>
          Data authors di database lokal sudah up-to-date. Tidak ada perubahan yang perlu disinkronkan.
        </div>
      <?php else: ?>
        <div class="table-responsive border rounded" style="max-height: 600px; overflow-y: auto;">
          <table class="table table-sm table-hover mb-0 align-middle">
            <thead class="table-light position-sticky top-0" style="z-index:1;">
              <tr>
                <th style="width: 90px;">Type</th>
                <th>Nama &amp; SINTA ID</th>
                <th style="width: 280px;">Perubahan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach (($inserted ?? []) as $author): ?>
                <tr>
                  <td><span class="badge bg-primary"><i class="bi bi-plus-lg me-1"></i>INSERT</span></td>
                  <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars((string) ($author['fullname'] ?? $author['nama'] ?? '-')); ?></div>
                    <div class="small text-muted">NIDN: <?php echo htmlspecialchars((string) ($author['nidn'] ?? '-')); ?></div>
                    <div class="small text-muted">ID: <?php echo htmlspecialchars((string) ($author['id_sinta'] ?? '-')); ?></div>
                  </td>
                  <td>
                    <div class="small text-muted">Author baru akan ditambahkan ke tabel <code>authors</code>.</div>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php foreach (($updated ?? []) as $author): ?>
                <tr>
                  <td><span class="badge bg-success"><i class="bi bi-pencil me-1"></i>UPDATE</span></td>
                  <td>
                    <div class="fw-semibold"><?php echo htmlspecialchars((string) ($author['fullname'] ?? '-')); ?></div>
                    <div class="small text-muted">NIDN: <?php echo htmlspecialchars((string) ($author['nidn'] ?? '-')); ?></div>
                    <div class="small text-muted">ID: <?php echo htmlspecialchars((string) ($author['id_sinta'] ?? '-')); ?></div>
                  </td>
                  <td>
                    <?php if (!empty($author['changes']) && is_array($author['changes'])): ?>
                      <div class="d-flex flex-wrap gap-1 mb-1">
                        <?php foreach ($author['changes'] as $change): ?>
                          <span class="badge bg-light text-dark border"><?php echo htmlspecialchars((string) ($change['label'] ?? $change['field'] ?? '-')); ?></span>
                        <?php endforeach; ?>
                      </div>
                      <div class="small text-muted">
                        <?php foreach ($author['changes'] as $change): ?>
                          <div>
                            <strong><?php echo htmlspecialchars((string) ($change['label'] ?? $change['field'] ?? '-')); ?>:</strong>
                            <?php echo htmlspecialchars((string) (($change['old'] ?? null) === null ? '-' : $change['old'])); ?>
                            &rarr;
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

      <div class="mt-3 d-flex gap-2 flex-wrap">
        <a href="<?php echo BASE_URL; ?>scraping" class="btn btn-secondary">Batal</a>
        <button type="button" class="btn btn-warning fw-semibold" id="btnExecuteSync" <?php echo $hasChanges ? '' : 'disabled'; ?>>
          <i class="bi bi-database-fill-up me-1"></i>Confirm Sync
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
        '<span class="spinner-border spinner-border-sm me-1"></span>Processing…' :
        originalHtml;
    }

    function showAlert(type, message) {
      syncAlert.className = `alert py-2 small mb-3 alert-${type}`;
      syncAlert.textContent = message;
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
      } catch (err) {
        console.error('executeSync error:', err);
        showAlert('danger', 'Network error saat mengeksekusi sync.');
      } finally {
        setBtnLoading(btnExecute, false, originalHtml);
      }
    });
  });
</script>