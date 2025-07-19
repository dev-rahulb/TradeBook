<!-- app/Views/layout/topbar.php -->

<!-- Add Bootstrap Icons CDN in your main layout <head> if not already included -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> -->

<div class="topbar d-flex justify-content-between align-items-center p-2 bg-light shadow-sm">
  <div class="left-content d-flex align-items-center gap-2 ms-3">
    <!-- Show image logo if available, else show book icon -->
    <?php if (is_file(FCPATH . 'logo.png')): ?>
      <img src="<?= base_url('logo.png') ?>" alt="TradeBook Logo" height="30">
    <?php else: ?>
      <i class="bi bi-journal-bookmark-fill fs-4 text-primary"></i>
    <?php endif; ?>
    <span class="fw-bold">Welcome, <?= session('user_name') ?></span>
  </div>

  <div class="d-flex align-items-center gap-3 me-3">
    <small class="text-muted fst-italic"><?= session('slogan') ?? 'Trade with Calm & Clarity' ?></small>
    <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-warning">Logout</a>
  </div>
</div>
