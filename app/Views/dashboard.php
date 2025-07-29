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
 <h5 class="mt-5">📈 Profit/Loss</h5>
<div id="capitalCandleChart" style="height: 400px;"></div>
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
<?php if (!empty($fearDays)): ?>
    <h4 class="mt-4">⚠️ Fear Days (Psychological Triggers)</h4>
    <div class="row">
        <?php foreach ($fearDays as $day): ?>
            <div class="col-md-6 mb-3">
                <div class="card border-danger shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <?= date('D, d M Y', strtotime($day['date'])) ?> - <?= $day['fear_reason'] ?>
                    </div>
                    <div class="card-body">
                        <p><strong>Total Trades:</strong> <?= $day['total_trades'] ?></p>
                        <p><strong>Net P&L:</strong> <span class="text-danger">₹<?= number_format($day['net_pnl'], 2) ?></span></p>
                        <?php if (!empty($day['unique_mistakes'])): ?>
                            <p><strong>Mistakes:</strong> <?= implode(', ', $day['unique_mistakes']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($day['lessons'])): ?>
                            <p><strong>Lessons:</strong> <?= implode('. ', $day['lessons']) ?>.</p>
                        <?php endif; ?>
                        <?php if ($day['no_mistake_count']): ?>
                            <p><em><?= $day['no_mistake_count'] ?> trades had no mistakes logged.</em></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
fetch("<?= base_url('analytics/dailyCapitalPnLChart') ?>")
  .then(res => res.json())
  .then(data => {
    const candleData = data.map(d => ({
      x: d.x,
      y: d.y,
      cumulative_pnl: d.cumulative_pnl // Attach this for custom tooltip
    }));

    const cumulativePnLLine = data.map(d => ({
      x: d.x,
      y: d.cumulative_pnl
    }));

    const options = {
      chart: {
        type: 'candlestick',
        height: 350,
        id: 'candles',
        toolbar: { autoSelected: 'pan', show: false },
        animations: { enabled: true }
      },
      series: [{
        name: 'Daily P&L Range',
        data: candleData
      }],
      xaxis: {
        type: 'category',
        labels: { rotate: -45 }
      },
      yaxis: [{
        tooltip: { enabled: true }
      }],
      tooltip: {
        custom: function({ series, seriesIndex, dataPointIndex, w }) {
          const d = candleData[dataPointIndex];
          const [open, high, low, close] = d.y;
          return `
            <div style="padding: 8px;">
              <strong>Date:</strong> ${d.x}<br/>
              <strong>Open:</strong> ₹${open}<br/>
              <strong>High:</strong> ₹${high}<br/>
              <strong>Low:</strong> ₹${low}<br/>
              <strong>Close:</strong> ₹${close}<br/>
              <strong>Net P&L:</strong> ₹${d.cumulative_pnl}
            </div>`;
        }
      }
    };

    const chart = new ApexCharts(document.querySelector("#capitalCandleChart"), options);
    chart.render();

    // Add line chart below
    const lineOptions = {
      chart: {
        height: 200,
        type: 'line',
        foreColor: '#999'
      },
      series: [{
        name: 'Cumulative P&L',
        data: cumulativePnLLine
      }],
      xaxis: {
        type: 'category',
        labels: { rotate: -45 }
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      }
    };

    const lineChart = new ApexCharts(document.createElement("div"), lineOptions);
    document.querySelector("#capitalCandleChart").appendChild(lineChart.render().containerEl);
    lineChart.render();
  });

</script>
<?= $this->endSection() ?>
