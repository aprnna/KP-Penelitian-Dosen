<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h4 class="mb-0 fw-bold">
            <i class="bi bi-pencil me-2"></i>Edit User
          </h4>
          <a href="<?php echo BASE_URL; ?>user" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Kembali
          </a>
        </div>
        <div class="card-body p-4">
          <form action="<?php echo BASE_URL; ?>user/update/<?php echo $editUser->id; ?>" method="POST">
            <div class="mb-3">
              <label for="name" class="form-label fw-medium">Nama</label>
              <input type="text" class="form-control" id="name" name="name" 
                     value="<?php echo htmlspecialchars($editUser->name ?? $editUser->full_name ?? ''); ?>" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fw-medium">Email</label>
              <input type="email" class="form-control" id="email" name="email" 
                     value="<?php echo htmlspecialchars($editUser->email); ?>" required>
            </div>
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-success">
                <i class="bi bi-check-lg me-1"></i>Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
