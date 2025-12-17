<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h4 class="mb-0 fw-bold">
            <i class="bi bi-person me-2"></i>User Detail
          </h4>
          <a href="<?php echo BASE_URL; ?>user" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
          </a>
        </div>
        <div class="card-body p-4">
          <div class="row">
            <div class="col-md-6">
              <table class="table table-borderless">
                <tr>
                  <th class="text-muted" width="150">ID</th>
                  <td><?php echo htmlspecialchars($detailUser->id); ?></td>
                </tr>
                <tr>
                  <th class="text-muted">Nama</th>
                  <td><?php echo htmlspecialchars($detailUser->name ?? $detailUser->full_name ?? '-'); ?></td>
                </tr>
                <tr>
                  <th class="text-muted">Email</th>
                  <td><?php echo htmlspecialchars($detailUser->email); ?></td>
                </tr>
                <tr>
                  <th class="text-muted">Username</th>
                  <td><?php echo htmlspecialchars($detailUser->username ?? '-'); ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
