<!-- app/Views/layouts/sidebar.php -->
<div class="sidebar d-flex flex-column position-fixed">
  <div class="text-center py-4">
    <h4>📘 TradeBook</h4>
  </div>
  <a href="<?= base_url('dashboard') ?>" class="<?= current_url() == base_url('dashboard') ? 'active' : '' ?>">📊 Dashboard</a>
  <a href="<?= base_url('journal') ?>" class="<?= current_url() == base_url('journal') ? 'active' : '' ?>">📓 Journal</a>
  <a href="<?= base_url('analytics') ?>" class="<?= current_url() == base_url('analytics') ? 'active' : '' ?>">📈 Analytics</a>
  <a href="<?= base_url('profile') ?>" class="<?= current_url() == base_url('profile') ? 'active' : '' ?>">👤 Profile</a>
</div>
