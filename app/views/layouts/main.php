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
  <?php if (isset($extraCss)): ?>
    <?php echo $extraCss; ?>
  <?php endif; ?>
</head>

<body class="bg-light">
  <?php if (isset($showNavbar) && $showNavbar): ?>
    <?php require_once '../app/views/partials/navbar.php'; ?>
  <?php endif; ?>

  <main class="min-vh-100 " style="background-color:#F6FCFF">
    <?php require_once '../app/views/' . $viewContent . '.php'; ?>
  </main>
  <!-- 
  <?php if (isset($showFooter) && $showFooter): ?>
    <?php require_once '../app/views/partials/footer.php'; ?>
  <?php endif; ?> 
  -->

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
  <!-- Chart.js Treemap Plugin -->
  <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-treemap@2.3.0/dist/chartjs-chart-treemap.min.js"></script>
  <?php if (isset($extraJs)): ?>
    <?php echo $extraJs; ?>
  <?php endif; ?>
</body>

</html>