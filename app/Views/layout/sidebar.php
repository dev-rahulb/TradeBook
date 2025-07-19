<!-- app/Views/layout/sidebar.php -->
<div class="sidebar d-flex flex-column position-fixed">
  <div class="text-center py-4 border-bottom border-light">
    <h4 class="fw-bold mb-0">📘 TradeBook</h4>
    <small class="text-light opacity-75">Your Trading Journal</small>
  </div>

  <a href="<?= base_url('dashboard') ?>" class="<?= current_url() == base_url('dashboard') ? 'active' : '' ?>">
    📊 Dashboard
  </a>

  <a href="<?= base_url('journal/calendar') ?>" class="<?= current_url() == base_url('journal/calendar') ? 'active' : '' ?>">
    🗓️ Calendar
  </a>

  <a href="<?= base_url('journal') ?>" class="<?= current_url() == base_url('journal') ? 'active' : '' ?>">
    📓 Journal
  </a>

  <a href="<?= base_url('analytics') ?>" class="<?= current_url() == base_url('analytics') ? 'active' : '' ?>">
    📈 Analytics
  </a>

  <a href="<?= base_url('ai-coach') ?>" class="<?= current_url() == base_url('ai-coach') ? 'active' : '' ?>">
    🧠 AI Coach
  </a>
</div>
