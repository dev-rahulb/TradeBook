<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">➕ Add Journal Entry</h2>

  <form action="<?= base_url('journal/store') ?>" method="post" class="mt-4 needs-validation" novalidate>
    <div class="row g-3">

      <!-- Date and Stock -->
      <div class="col-md-3">
        <label for="date" class="form-label">📅 Date <span class="text-danger">*</span></label>
        <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        <div class="invalid-feedback">Please select a date.</div>
      </div>
      <div class="col-md-3">
        <label for="stock" class="form-label">📈 Stock <span class="text-danger">*</span></label>
        <input type="text" name="stock" class="form-control" required>
        <div class="invalid-feedback">Stock name is required.</div>
      </div>
  <!-- Strategy Type -->
      <div class="col-md-3">
        <label for="strategy_type" class="form-label">🎯 Strategy Type</label>
        <select name="strategy_type" id="strategy_type" class="form-select" required>
          <option value="" selected disabled>-- Select Strategy --</option>
          <option value="Breakout">Breakout</option>
          <option value="Reversal">Reversal</option>
          <option value="Scalping">Scalping</option>
          <option value="Range Bound">Range Bound</option>
          <option value="News Based">News Based</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <!-- Calmness -->
      <div class="col-md-3">
        <label for="calmness" class="form-label">😌 Calmness (%)</label>
        <select name="calmness" id="calmness" class="form-select" required>
          <option value="" selected disabled>-- How Calm Were You? --</option>
          <option value="100">100% - Very Calm</option>
          <option value="90">90%</option>
          <option value="80">80%</option>
          <option value="70">70%</option>
          <option value="60">60%</option>
          <option value="50">50% - Neutral</option>
          <option value="40">40%</option>
          <option value="30">30%</option>
          <option value="20">20%</option>
          <option value="10">10%</option>
          <option value="0">0% - Totally Panicked</option>
        </select>
      </div>

      <!-- SL/Target -->
      <div class="col-md-3">
        <label for="stop_loss" class="form-label">🛑 Stop Loss <span class="text-danger">*</span></label>
        <input type="number" name="stop_loss" step="0.01" class="form-control" required>
        <div class="invalid-feedback">Stop Loss is required.</div>
      </div>
      <div class="col-md-3">
        <label for="target" class="form-label">🎯 Target <span class="text-danger">*</span></label>
        <input type="number" name="target" step="0.01" class="form-control" required>
        <div class="invalid-feedback">Target is required.</div>
      </div>

      <!-- Time -->
      <div class="col-md-3">
        <label for="buy_time" class="form-label">🕒 Buy Time <span class="text-danger">*</span></label>
        <input type="time" name="buy_time" class="form-control" required>
        <div class="invalid-feedback">Buy Time is required.</div>
      </div>
      <div class="col-md-3">
        <label for="sell_time" class="form-label">🕓 Sell Time <span class="text-danger">*</span></label>
        <input type="time" name="sell_time" class="form-control" required>
        <div class="invalid-feedback">Sell Time is required.</div>
      </div>

      <!-- Price -->
      <div class="col-md-3">
        <label for="buy_price" class="form-label">💰 Buy Price <span class="text-danger">*</span></label>
        <input type="number" name="buy_price" step="0.01" class="form-control" id="buy_price" required>
        <div class="invalid-feedback">Buy Price is required.</div>
      </div>
      <div class="col-md-3">
        <label for="sell_price" class="form-label">💵 Sell Price <span class="text-danger">*</span></label>
        <input type="number" name="sell_price" step="0.01" class="form-control" id="sell_price" required>
        <div class="invalid-feedback">Sell Price is required.</div>
      </div>

      <!-- Qty and PnL -->
      <div class="col-md-3">
        <label for="qty" class="form-label">📦 Quantity <span class="text-danger">*</span></label>
        <input type="number" name="qty" class="form-control" id="qty" required>
        <div class="invalid-feedback">Quantity is required.</div>
      </div>
      <div class="col-md-3">
        <label for="pnl" class="form-label">📊 P&L (₹) <span class="text-danger">*</span></label>
        <input type="number" name="pnl" step="0.01" class="form-control" id="pnl" readonly required>
        <div class="invalid-feedback">P&L will be calculated automatically but is required.</div>
      </div>

      <!-- Entry/Exit Reason -->
      <div class="col-md-6">
        <label for="entry_reason" class="form-label">📌 Entry Reason <span class="text-danger">*</span></label>
        <textarea name="entry_reason" class="form-control" rows="2" required></textarea>
        <div class="invalid-feedback">Please describe your entry reason.</div>
      </div>
      <div class="col-md-6">
        <label for="exit_reason" class="form-label">📍 Exit Reason <span class="text-danger">*</span></label>
        <textarea name="exit_reason" class="form-control" rows="2" required></textarea>
        <div class="invalid-feedback">Please describe your exit reason.</div>
      </div>

      <!-- Mistake / Lesson -->
      <div class="col-md-6">
        <label for="mistake" class="form-label">⚠️ Mistake <span class="text-danger">*</span></label>
        <textarea name="mistake" class="form-control" rows="2" required></textarea>
        <div class="invalid-feedback">Please mention your mistake if any.</div>
      </div>
      <div class="col-md-6">
        <label for="lesson" class="form-label">📘 Lessons Learned <span class="text-danger">*</span></label>
        <textarea name="lesson" class="form-control" rows="2" required></textarea>
        <div class="invalid-feedback">Please write what you learned.</div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="mt-4">
      <button type="submit" class="btn btn-success">💾 Save Entry</button>
      <a href="<?= base_url('journal') ?>" class="btn btn-secondary">⬅ Back</a>
    </div>
  </form>
</div>

<!-- Bootstrap Validation + Auto P&L -->
<script>
  // Bootstrap validation
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

  // Auto calculate P&L
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
</script>

<?= $this->endSection() ?>
