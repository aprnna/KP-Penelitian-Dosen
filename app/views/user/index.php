<div class="container py-5">
  <div class="row">
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h4 class="mb-0 fw-bold">
            <i class="bi bi-people me-2"></i>User List
          </h4>
        </div>
        <div class="card-body p-4">
          <?php if (!empty($users)): ?>
            <div class="table-responsive">
              <table class="table table-hover table-striped align-middle">
                <thead class="table-success">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($users as $u): ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?php echo $u->id; ?></td>
                      <td>
                        <i class="bi bi-person me-1 text-muted"></i>
                        <?php echo htmlspecialchars($u->name); ?>
                      </td>
                      <td>
                        <i class="bi bi-envelope me-1 text-muted"></i>
                        <?php echo htmlspecialchars($u->email); ?>
                      </td>
                      <td class="text-center">
                        <a href="<?php echo BASE_URL; ?>user/detail/<?php echo $u->id; ?>" class="btn btn-success btn-sm">
                          <i class="bi bi-eye me-1"></i>View
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="alert alert-info" role="alert">
              <i class="bi bi-info-circle me-2"></i>No users found.
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>