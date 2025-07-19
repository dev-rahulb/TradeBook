<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mb-4">📊 Trading Analytics Dashboard</h2>

  <!-- Date Filter Form -->
  <form method="get" class="row g-3 mb-4">
    <div class="col-md-3">
      <label for="start_date" class="form-label">Start Date</label>
      <input type="date" name="start_date" id="start_date" value="<?= esc($start_date) ?>" class="form-control" />
    </div>
    <div class="col-md-3">
      <label for="end_date" class="form-label">End Date</label>
      <input type="date" name="end_date" id="end_date" value="<?= esc($end_date) ?>" class="form-control" />
    </div>
    <div class="col-md-3 align-self-end">
      <button type="submit" class="btn btn-primary">Filter</button>
    </div>
  </form>

  <!-- Summary Cards -->
  <div class="row g-4">
    <div class="col-md-3">
      <div class="card bg-light border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Total Trades</h5>
          <h3><?= $totalTrades ?></h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-success text-white border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Total Profit</h5>
          <h3>₹<?= number_format($totalProfit, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-danger text-white border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Total Loss</h5>
          <h3>₹<?= number_format($totalLoss, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-warning text-dark border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Net P&L</h5>
          <h3>₹<?= number_format($netPnL, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-info text-white border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Average P&L</h5>
          <h3>₹<?= number_format($averagePnL, 2) ?></h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-secondary text-white border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Win Rate</h5>
          <h3><?= round($winRate, 2) ?>%</h3>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card bg-light border-0 shadow-sm">
        <div class="card-body text-center">
          <h5>Avg Duration</h5>
          <h3><?= $durationStats['avg_minutes'] ?? '-' ?> min</h3>
          <small>Min: <?= $durationStats['min_minutes'] ?? '-' ?> | Max: <?= $durationStats['max_minutes'] ?? '-' ?></small>
        </div>
      </div>
    </div>
  </div>
<div class="col-md-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h6 class="card-title">🏆 Top Strategy</h6>
      <p class="fs-5 mb-0"><?= esc($topStrategy['strategy'] ?? 'N/A') ?></p>
      <small class="text-muted">Total P&L: ₹<?= number_format($topStrategy['total_pnl'] ?? 0, 2) ?></small>
    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h6 class="card-title">📊 Avg Risk-Reward</h6>
      <p class="fs-5 mb-0"><?= esc($avgRiskReward ?? 'N/A') ?></p>
    </div>
  </div>
</div>

  <!-- Charts -->
  <div class="row g-4 mt-4">
    <!-- Monthly P&L Chart -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>📆 Monthly P&L</h5>
          <canvas id="monthlyPnLChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <!-- Strategy Chart -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>📊 Strategy Type Distribution</h5>
          <canvas id="strategyChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <!-- Mistake Chart -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>⚠️ Mistake Frequency</h5>
          <canvas id="mistakeChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <!-- Calmness Chart -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>🧘 Calmness Score Distribution</h5>
          <canvas id="calmnessChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <!-- Day of Week Stats -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>📅 Day of Week Performance</h5>
          <canvas id="dayChart" height="200"></canvas>
        </div>
      </div>
    </div>

    <!-- Profit Distribution -->
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>💰 Profit Distribution</h5>
          <canvas id="pnlDistChart" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Best and Worst Trades -->
  <div class="row g-4 mt-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>🏆 Top 5 Best Trades</h5>
          <ul class="list-group">
            <?php foreach ($bestTrades as $trade): ?>
              <li class="list-group-item d-flex justify-content-between">
                <span><?= esc($trade['stock']) ?> (<?= esc($trade['date']) ?>)</span>
                <span class="text-success fw-bold">₹<?= number_format($trade['pnl'], 2) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5>💥 Top 5 Worst Trades</h5>
          <ul class="list-group">
            <?php foreach ($worstTrades as $trade): ?>
              <li class="list-group-item d-flex justify-content-between">
                <span><?= esc($trade['stock']) ?> (<?= esc($trade['date']) ?>)</span>
                <span class="text-danger fw-bold">₹<?= number_format($trade['pnl'], 2) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  new Chart(document.getElementById('monthlyPnLChart'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($monthlyPnL)) ?>,
      datasets: [{
        label: 'Monthly P&L',
        data: <?= json_encode(array_values($monthlyPnL)) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.6)'
      }]
    }
  });

  new Chart(document.getElementById('strategyChart'), {
    type: 'pie',
    data: {
      labels: <?= json_encode(array_keys($strategyCounts)) ?>,
      datasets: [{
        data: <?= json_encode(array_values($strategyCounts)) ?>,
        backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6f42c1']
      }]
    }
  });

  new Chart(document.getElementById('mistakeChart'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_keys($mistakeCounts)) ?>,
      datasets: [{
        label: 'Count',
        data: <?= json_encode(array_values($mistakeCounts)) ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.6)'
      }]
    }
  });

  new Chart(document.getElementById('calmnessChart'), {
    type: 'pie',
    data: {
      labels: <?= json_encode(array_keys($calmnessCounts)) ?>,
      datasets: [{
        data: <?= json_encode(array_values($calmnessCounts)) ?>,
        backgroundColor: ['#00bcd4', '#4caf50', '#ff9800', '#f44336']
      }]
    }
  });

  new Chart(document.getElementById('dayChart'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($dayStats, 'day')) ?>,
      datasets: [{
        label: 'Day-wise P&L',
        data: <?= json_encode(array_column($dayStats, 'pnl')) ?>,
        backgroundColor: 'rgba(255, 206, 86, 0.6)'
      }]
    }
  });

  new Chart(document.getElementById('pnlDistChart'), {
    type: 'line',
    data: {
      labels: <?= json_encode(range(1, count($profitDistribution))) ?>,
      datasets: [{
        label: 'P&L Distribution',
        data: <?= json_encode(array_column($profitDistribution, 'pnl')) ?>,
        borderColor: 'rgba(153, 102, 255, 1)',
        backgroundColor: 'rgba(153, 102, 255, 0.3)',
        tension: 0.3,
        fill: true
      }]
    }
  });
</script>

<?= $this->endSection() ?>
