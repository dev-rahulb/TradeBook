<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">📆 Trades for <?= esc($date) ?></h2>

  <?php if (empty($entries)) : ?>
    <div class="alert alert-info mt-3">No trades found for this day.</div>
  <?php else: ?>
    <table class="table table-bordered mt-3">
      <thead class="table-light">
        <tr>
          <th>Stock</th>
          <th>Qty</th>
          <th>Buy</th>
          <th>Sell</th>
          <th>P&L</th>
          <th>Lesson</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($entries as $entry) : ?>
          <tr>
            <td><?= esc($entry['stock']) ?></td>
            <td><?= esc($entry['quantity']) ?></td>
            <td><?= esc($entry['buy_price']) ?></td>
            <td><?= esc($entry['sell_price']) ?></td>
            <td><?= esc($entry['sell_price'] - $entry['buy_price']) ?></td>
            <td><?= esc($entry['lessons']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<?= $this->endSection() ?>
