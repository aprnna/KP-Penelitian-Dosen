<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'KP Penelitian Dosen'; ?></title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS - Override Bootstrap Colors -->
  <link href="<?php echo BASE_URL; ?>css/custom.css" rel="stylesheet">
</head>
<style>
  .login-header {
    background: #357CA5;
    border-radius: 5px;
    padding: 0.75rem 2rem;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    width: 100%;
  }

  .login-header img {
    height: 40px;
    width: auto;
  }

  .login-header span {
    color: white;
    font-size: 1.1rem;
    font-weight: 600;
  }
</style>

<body class="bg-light">
  <div class="min-vh-100 d-flex justify-content-center align-items-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
          <div class="login-header">
            <img src="<?php echo BASE_URL; ?>logo_only.png" alt="Logo UNIKOM">
            <span>Visualisasi Penelitian</span>
          </div>
          <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
              <?php require_once '../app/views/' . $viewContent . '.php'; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>