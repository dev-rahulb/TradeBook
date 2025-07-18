<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">✏️ Edit Journal Entry</h2>

  <form action="<?= base_url('journal/update/' . $entry['id']) ?>" method="post" class="mt-4 needs-validation" novalidate>
    <div class="row g-3">

      <!-- Date and Stock -->
      <div class="col-md-3">
        <label for="date" class="form-label">📅 Date <span class="text-danger">*</span></label>
        <input type="date" name="date" class="form-control" value="<?= esc($entry['date']) ?>" required>
        <div class="invalid-feedback">Please select a date.</div>
      </div>
      <div class="col-md-3">
        <label for="stock" class="form-label">📈 Stock <span class="text-danger">*</span></label>
        <input type="text" name="stock" class="form-control" value="<?= esc($entry['stock']) ?>" required>
        <div class="invalid-feedback">Stock name is required.</div>
      </div>
<div class="col-md-3">
  <label for="strategy_type" class="form-label">Strategy Type</label>
  <select name="strategy_type" id="strategy_type" class="form-select" required>
    <option value="" disabled>-- Select Strategy --</option>
    <option value="Breakout" <?= $entry['strategy_type'] == 'Breakout' ? 'selected' : '' ?>>Breakout</option>
    <option value="Reversal" <?= $entry['strategy_type'] == 'Reversal' ? 'selected' : '' ?>>Reversal</option>
    <option value="Scalping" <?= $entry['strategy_type'] == 'Scalping' ? 'selected' : '' ?>>Scalping</option>
    <option value="Range Bound" <?= $entry['strategy_type'] == 'Range Bound' ? 'selected' : '' ?>>Range Bound</option>
    <option value="News Based" <?= $entry['strategy_type'] == 'News Based' ? 'selected' : '' ?>>News Based</option>
    <option value="Other" <?= $entry['strategy_type'] == 'Other' ? 'selected' : '' ?>>Other</option>
  </select>
</div>
<div class="col-md-3">
  <label for="calmness" class="form-label">Calmness (%)</label>
  <select name="calmness" id="calmness" class="form-select" required>
    <option value="" disabled>-- How Calm Were You? --</option>
    <?php
      for ($i = 100; $i >= 0; $i -= 10):
        $label = $i . '%';
        if ($i == 100) $label .= ' - Very Calm';
        if ($i == 50) $label .= ' - Neutral';
        if ($i == 0) $label .= ' - Totally Panicked';
    ?>
      <option value="<?= $i ?>" <?= ($entry['calmness'] == $i) ? 'selected' : '' ?>><?= $label ?></option>
    <?php endfor; ?>
  </select>
</div>

      <!-- SL/Target -->
      <div class="col-md-3">
        <label for="stop_loss" class="form-label">🛑 Stop Loss <span class="text-danger">*</span></label>
        <input type="number" name="stop_loss" step="0.01" class="form-control" value="<?= esc($entry['stop_loss']) ?>" required>
        <div class="invalid-feedback">Stop Loss is required.</div>
      </div>
      <div class="col-md-3">
        <label for="target" class="form-label">🎯 Target <span class="text-danger">*</span></label>
        <input type="number" name="target" step="0.01" class="form-control" value="<?= esc($entry['target']) ?>" required>
        <div class="invalid-feedback">Target is required.</div>
      </div>

      <!-- Time -->
      <div class="col-md-3">
        <label for="buy_time" class="form-label">🕒 Buy Time <span class="text-danger">*</span></label>
        <input type="time" name="buy_time" class="form-control" value="<?= esc($entry['buy_time']) ?>" required>
        <div class="invalid-feedback">Buy Time is required.</div>
      </div>
      <div class="col-md-3">
        <label for="sell_time" class="form-label">🕓 Sell Time <span class="text-danger">*</span></label>
        <input type="time" name="sell_time" class="form-control" value="<?= esc($entry['sell_time']) ?>" required>
        <div class="invalid-feedback">Sell Time is required.</div>
      </div>

      <!-- Price -->
      <div class="col-md-3">
        <label for="buy_price" class="form-label">💰 Buy Price <span class="text-danger">*</span></label>
        <input type="number" name="buy_price" step="0.01" class="form-control" id="buy_price" value="<?= esc($entry['buy_price']) ?>" required>
        <div class="invalid-feedback">Buy Price is required.</div>
      </div>
      <div class="col-md-3">
        <label for="sell_price" class="form-label">💵 Sell Price <span class="text-danger">*</span></label>
        <input type="number" name="sell_price" step="0.01" class="form-control" id="sell_price" value="<?= esc($entry['sell_price']) ?>" required>
        <div class="invalid-feedback">Sell Price is required.</div>
      </div>

      <!-- Qty and PnL -->
      <div class="col-md-3">
        <label for="qty" class="form-label">📦 Quantity <span class="text-danger">*</span></label>
        <input type="number" name="qty" class="form-control" id="qty" value="<?= esc($entry['quantity']) ?>" required>
        <div class="invalid-feedback">Quantity is required.</div>
      </div>
      <div class="col-md-3">
        <label for="pnl" class="form-label">📊 P&L (₹) <span class="text-danger">*</span></label>
        <input type="number" name="pnl" step="0.01" class="form-control" id="pnl" value="<?= esc($entry['pnl']) ?>" readonly required>
        <div class="invalid-feedback">P&L will be calculated automatically but is required.</div>
      </div>

      <!-- Entry/Exit Reason -->
      <div class="col-md-6">
        <label for="entry_reason" class="form-label">📌 Entry Reason <span class="text-danger">*</span></label>
        <textarea name="entry_reason" class="form-control" rows="2" required><?= esc($entry['entry_reason']) ?></textarea>
        <div class="invalid-feedback">Please describe your entry reason.</div>
      </div>
      <div class="col-md-6">
        <label for="exit_reason" class="form-label">📍 Exit Reason <span class="text-danger">*</span></label>
        <textarea name="exit_reason" class="form-control" rows="2" required><?= esc($entry['exit_reason']) ?></textarea>
        <div class="invalid-feedback">Please describe your exit reason.</div>
      </div>

      <!-- Mistake / Lesson -->
      <div class="col-md-6">
        <label for="mistake" class="form-label">⚠️ Mistake <span class="text-danger">*</span></label>
        <textarea name="mistake" class="form-control" rows="2" required><?= esc($entry['mistake']) ?></textarea>
        <div class="invalid-feedback">Please mention your mistake if any.</div>
      </div>
      <div class="col-md-6">
        <label for="lesson" class="form-label">📘 Lessons Learned <span class="text-danger">*</span></label>
        <textarea name="lesson" class="form-control" rows="2" required><?= esc($entry['lessons']) ?></textarea>
        <div class="invalid-feedback">Please write what you learned.</div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-4">
      <button type="submit" class="btn btn-primary">💾 Update Entry</button>
      <a href="<?= base_url('journal') ?>" class="btn btn-secondary">⬅ Cancel</a>
    </div>
  </form>
</div>

<!-- Bootstrap Validation + Auto P&L -->
<script>
  (() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();

  // Auto P&L calculation
  const buyInput = document.getElementById('buy_price');
  const sellInput = document.getElementById('sell_price');
  const qtyInput = document.getElementById('qty');
  const pnlInput = document.getElementById('pnl');

  function calculatePnL() {
    const buy = parseFloat(buyInput.value);
    const sell = parseFloat(sellInput.value);
    const qty = parseInt(qtyInput.value);

    if (!isNaN(buy) && !isNaN(sell) && !isNaN(qty)) {
      const pnl = (sell - buy) * qty;
      pnlInput.value = pnl.toFixed(2);
    } else {
      pnlInput.value = '';
    }
  }

  [buyInput, sellInput, qtyInput].forEach(input => {
    input.addEventListener('input', calculatePnL);
  });

  // Initial PnL update
  calculatePnL();
</script>

<?= $this->endSection() ?>
