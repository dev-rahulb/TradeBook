<!-- app/Views/layouts/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'TradeBook' ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f8fb;
      margin: 0;
    }

    .navbar {
      background: linear-gradient(to right, #6c63ff, #7b68ee);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .navbar-brand {
      font-weight: bold;
      color: #fff !important;
      font-size: 1.5rem;
    }

    .navbar-nav .nav-link {
      color: #f1f1f1 !important;
      margin-right: 15px;
    }

    .navbar-nav .nav-link:hover {
      color: #ffd369 !important;
    }

    .btn-custom {
      background: #ffd369;
      color: #111;
      border-radius: 30px;
      padding: 8px 20px;
    }

    .btn-custom:hover {
      background: #ffb347;
      color: #111;
    }

    footer {
      background: linear-gradient(to right, #6c63ff, #7b68ee);
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 0.9rem;
      position: relative;
      bottom: 0;
      width: 100%;
    }

    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 1.2rem;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="<?= base_url('/') ?>">
      <img src="https://cdn-icons-png.flaticon.com/512/711/711769.png" alt="Logo" height="30" class="me-2">
      TradeBook
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2 mt-lg-0" id="navbarContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('journal') ?>">Journal</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('analytics') ?>">Analytics</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('profile') ?>">Profile</a></li>
        <li class="nav-item">
          <a href="<?= base_url('logout') ?>" class="btn btn-custom">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
