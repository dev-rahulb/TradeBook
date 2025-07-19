<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid px-4">
  <h2 class="mb-4">📈 Analytical Dashboard</h2>

  <div class="row g-4">
    <!-- Monthly P&L + Cumulative -->
    <div class="col-lg-6 col-md-12">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h5 class="card-title">📅 Monthly P&L & Cumulative</h5>
          <canvas id="monthlyPlChart" style="aspect-ratio: 2/1;"></canvas>
        </div>
      </div>
    </div>

    <!-- Strategy Win Rate -->
    <div class="col-lg-6 col-md-12">
      <div class="card shadow-sm border-0 h-100">
        <div class="card-body">
          <h5 class="card-title">🎯 Strategy Win Rate</h5>
          <canvas id="strategyPieChart" style="aspect-ratio: 1/1;"></canvas>
        </div>
      </div>
    </div>

    <!-- Day-wise Trades vs P&L -->
    <div class="col-12">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">📆 Trades & P&L by Day</h5>
          <canvas id="dayBarChart" style="aspect-ratio: 3/1;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const monthlyLabels = <?= json_encode(array_column($monthlyPL, 'month')) ?>;
  const monthlyData = <?= json_encode(array_map(fn($r) => (float)$r['total_pl'], $monthlyPL)) ?>;
  const cumulativeData = (() => {
    let sum = 0;
    return monthlyData.map(v => sum += v);
  })();

  new Chart(document.getElementById('monthlyPlChart'), {
    type: 'bar',
    data: {
      labels: monthlyLabels,
      datasets: [
        {
          type: 'bar',
          label: 'Monthly P&L (₹)',
          data: monthlyData,
          backgroundColor: '#0d6efd'
        },
        {
          type: 'line',
          label: 'Cumulative P&L (₹)',
          data: cumulativeData,
          borderColor: '#198754',
          borderWidth: 2,
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' }
      }
    }
  });

  const strategyLabels = <?= json_encode(array_column($strategyStats, 'strategy_type')) ?>;
  const winRates = <?= json_encode(array_map(fn($r) => $r['total'] > 0 ? round(($r['wins'] / $r['total']) * 100, 2) : 0, $strategyStats)) ?>;
  const strategyColors = ['#198754', '#ffc107', '#dc3545', '#0d6efd', '#6610f2', '#fd7e14'];

  new Chart(document.getElementById('strategyPieChart'), {
    type: 'doughnut',
    data: {
      labels: strategyLabels,
      datasets: [{
        data: winRates,
        backgroundColor: strategyColors
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'bottom' },
        tooltip: {
          callbacks: {
            label: function(context) {
              const index = context.dataIndex;
              const wins = <?= json_encode(array_column($strategyStats, 'wins')) ?>;
              const total = <?= json_encode(array_column($strategyStats, 'total')) ?>;
              return `${strategyLabels[index]}: ${winRates[index]}% (${wins[index]}/${total[index]})`;
            }
          }
        }
      }
    }
  });

  const dayLabels = <?= json_encode(array_column($dayStats, 'day')) ?>;
  const tradeCounts = <?= json_encode(array_map(fn($r) => (int)$r['total'], $dayStats)) ?>;
  const dayPL = <?= json_encode(array_map(fn($r) => round((float)$r['pl'], 2), $dayStats)) ?>;

  new Chart(document.getElementById('dayBarChart'), {
    type: 'bar',
    data: {
      labels: dayLabels,
      datasets: [
        {
          label: 'Number of Trades',
          data: tradeCounts,
          backgroundColor: '#6f42c1'
        },
        {
          label: 'Net P&L (₹)',
          data: dayPL,
          backgroundColor: '#20c997'
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' }
      }
    }
  });
</script>
<?= $this->endSection() ?>
