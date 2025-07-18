<!-- app/Views/dashboard.php -->
<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content') ?>
  <h2 class="mb-4">📊 Dashboard Overview</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Total Trades</h5>
          <p class="card-text display-6">127</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title">Win Rate</h5>
          <p class="card-text display-6">64%</p>
        </div>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>
