<!-- app/Views/layouts/main_layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'TradeBook Admin' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


  <style>
    body {
      background-color: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #1b1f3a, #2c2f5a);
      color: white;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 60px;
    }

    .sidebar a {
      color: #fff;
      display: block;
      padding: 14px 20px;
      text-decoration: none;
      font-weight: 500;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #3a3f70;
      border-left: 4px solid #ffc107;
    }

    .topbar {
      height: 60px;
      background-color: #fff;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      padding-left: 250px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-right: 20px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .topbar .left-content {
      display: flex;
      align-items: center;
      gap: 15px;
      font-weight: 600;
    }

    .topbar .left-content img {
      height: 30px;
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
        padding-top: 10px;
      }

      .topbar {
        padding-left: 0;
      }

      .main-content {
        margin-left: 0;
        padding: 15px;
      }
    }

    .select2-container .select2-selection--multiple {
      height: auto !important;
      min-height: 38px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<?= view('layout/sidebar') ?>

<!-- Topbar -->
<?= view('layout/topbar') ?>

<!-- Main Content -->
<div class="main-content">
  <?= $this->renderSection('content') ?>
</div>

<!-- Footer -->
<?= view('layout/footer') ?>

<!-- Scripts -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?= $this->section('scripts') ?>
<script>
  $(document).ready(function () {
    $('.select2').select2({
      placeholder: "Select options",
      allowClear: true
    });

    // any other jQuery logic here
  });
</script>
<?= $this->endSection() ?>
<!-- Page-specific JS -->
<?= $this->renderSection('scripts') ?>

</body>
</html>
