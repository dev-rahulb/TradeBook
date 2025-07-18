<!-- app/Views/partials/navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light px-4 py-3">
  <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
    <img src="https://cdn-icons-png.flaticon.com/512/711/711769.png" alt="Logo" width="35" class="me-2">
    TradeBook
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
    <ul class="navbar-nav">
      <?php if (session()->get('logged_in')): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('logout') ?>">Logout</a>
        </li>
      <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary ms-2" href="<?= base_url('signup') ?>">Get Started</a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
