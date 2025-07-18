<!-- app/Views/layouts/main_layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'TradeBook Admin' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #6c63ff, #7b68ee);
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
      padding: 15px 20px;
      text-decoration: none;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #5c57d3;
      border-left: 4px solid #ffd369;
    }

    .topbar {
      height: 60px;
      background-color: #ffffff;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
      padding-left: 250px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-right: 20px;
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
        padding-top: 0;
      }

      .topbar {
        padding-left: 0;
      }

      .main-content {
        margin-left: 0;
        padding: 15px;
      }
    }
  </style>
</head>
<body>

<?= view('layout/sidebar') ?>
<?= view('layout/topbar') ?>

<div class="main-content">
  <?= $this->renderSection('content') ?>
</div>

<?= view('layout/footer') ?>
