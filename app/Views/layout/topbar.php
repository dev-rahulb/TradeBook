<!-- app/Views/layouts/topbar.php -->
<div class="topbar">
  <div class="ms-3 fw-bold">Welcome, <?= session('user_name') ?></div>
  <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-warning">Logout</a>
</div>
