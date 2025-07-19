<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>


<div class="row g-4">
  <div class="col-md-3">
    <div class="card border-0 shadow-sm text-white bg-primary h-100">
      <div class="card-body text-center">
        <h6 class="card-title">Total Trades</h6>
        <h2 class="card-text"><?= esc($totalEntries) ?></h2>
        <i class="bi bi-journal-text fs-1"></i>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm text-white bg-success h-100">
      <div class="card-body text-center">
        <h6 class="card-title">Net P&L</h6>
        <h2 class="card-text">₹<?= number_format($totalPL, 2) ?></h2>
        <i class="bi bi-currency-rupee fs-1"></i>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm text-white bg-info h-100">
      <div class="card-body text-center">
        <h6 class="card-title">Win Rate</h6>
        <h2 class="card-text"><?= esc($winRate) ?>%</h2>
        <i class="bi bi-graph-up-arrow fs-1"></i>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card border-0 shadow-sm text-white bg-dark h-100">
      <div class="card-body text-center">
        <h6 class="card-title">Top Strategy</h6>
        <h5 class="card-text"><?= esc($topStrategy ?? 'N/A') ?></h5>
        <i class="bi bi-lightbulb fs-1"></i>
      </div>
    </div>
  </div>
</div>

<!-- Activity Feed -->
<div class="mt-5">
  <h4>📌 Recent Activity</h4>
  <ul class="list-group mt-3">
    <?php foreach ($recentEntries as $entry): ?>
      <li class="list-group-item d-flex justify-content-between align-items-start">
        <div class="ms-2 me-auto">
          <div class="fw-bold"><?= esc($entry['stock']) ?> (<?= esc($entry['date']) ?>)</div>
          <?= esc($entry['strategy_type']) ?> – Buy at ₹<?= esc($entry['buy_price']) ?> | Sell at ₹<?= esc($entry['sell_price']) ?>
        </div>
        <span class="badge bg-<?= $entry['pnl'] >= 0 ? 'success' : 'danger' ?> rounded-pill">
          ₹<?= number_format($entry['pnl'], 2) ?>
        </span>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<?= $this->endSection() ?>
