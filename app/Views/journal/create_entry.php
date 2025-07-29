<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">➕ Add Journal Entry</h2>

  <form action="<?= base_url('journal/store') ?>" method="post" class="mt-4 needs-validation" novalidate>
    <div class="row g-4">

      <!-- DATE & STOCK -->
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

      <div class="col-md-3">
        <label for="strategy_type" class="form-label">🎯 Strategy Type <span class="text-danger">*</span></label>
        <select name="strategy_type" id="strategy_type" class="form-select" required>
          <option value="" selected disabled>-- Select Strategy --</option>
          <option value="Breakout">Breakout</option>
          <option value="Reversal">Reversal</option>
          <option value="Scalping">Scalping</option>
          <option value="Range Bound">Range Bound</option>
          <option value="News Based">News Based</option>
          <option value="Other">Other</option>
        </select>
        <div class="invalid-feedback">Please select a strategy type.</div>
      </div>

      <div class="col-md-3">
        <label for="trade_type" class="form-label">📊 Trade Type <span class="text-danger">*</span></label>
        <select name="trade_type" id="trade_type" class="form-select" required>
          <option value="" selected disabled>-- Select Type --</option>
          <option value="Long" selected>Long (Buy First)</option>
          <option value="Short">Short (Sell First)</option>
        </select>
        <div class="invalid-feedback">Please select a trade type.</div>
      </div>

      <!-- BUY/SELL TIME -->
      <div class="col-md-3">
        <label for="buy_time" class="form-label">🕒 Buy Time </label>
        <input type="time" name="buy_time" class="form-control" >
        <div class="invalid-feedback">Buy Time is required.</div>
      </div>

      <div class="col-md-3">
        <label for="sell_time" class="form-label">🕓 Sell Time </label>
        <input type="time" name="sell_time" class="form-control" >
        <div class="invalid-feedback">Sell Time is required.</div>
      </div>

      <!-- PRICES & QTY -->
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

      <div class="col-md-3">
        <label for="qty" class="form-label">📦 Quantity <span class="text-danger">*</span></label>
        <input type="number" name="qty" class="form-control" id="qty" required>
        <div class="invalid-feedback">Quantity is required.</div>
      </div>

      <div class="col-md-3">
        <label for="pnl" class="form-label">📊 P&L (₹) <span class="text-danger">*</span></label>
        <input type="number" name="pnl" step="0.01" class="form-control" id="pnl" readonly required>
        <div class="invalid-feedback">P&L is required.</div>
      </div>

      <!-- STOPLOSS / TARGET / CONFIDENCE -->
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

      <div class="col-md-6">
  
  <label for="calmness" class="form-label">💡 Confidence Level: <span id="confidenceValue">50%</span></label>
  <input type="range" name="calmness" id="calmness" class="form-range" min="0" max="100" step="10" value="50" oninput="document.getElementById('confidenceValue').textContent = this.value + '%'">


      </div>

      <!-- ENTRY / EXIT REASONS -->
      <div class="col-md-6">
        <label for="entry_reasons" class="form-label">✅ Entry Reasons <span class="text-danger">*</span></label>
        <select name="entry_reason[]" id="entry_reasons" class="form-select select2" multiple required>
          <?php foreach ($entryReasons as $reason): ?>
            <option value="<?= $reason->id ?>" <?= in_array($reason->id, $selectedEntryReasons ?? []) ? 'selected' : '' ?>>
              <?= esc($reason->reason) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">
        <label for="exit_reasons" class="form-label">🚪 Exit Reasons <span class="text-danger">*</span></label>
        <select name="exit_reason[]" id="exit_reasons" class="form-select select2" multiple required>
          <?php foreach ($exitReasons as $reason): ?>
            <option value="<?= $reason->id ?>" <?= in_array($reason->id, $selectedExitReasons ?? []) ? 'selected' : '' ?>>
              <?= esc($reason->reason) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- MISTAKES / LESSONS -->
      <div class="col-md-6">
        <label for="mistakes" class="form-label">⚠️ Mistakes (if any)</label>
        <select name="mistake[]" id="mistakes" class="form-select select2" multiple>
          <?php foreach ($mistakes as $mistake): ?>
            <option value="<?= $mistake->id ?>"><?= esc($mistake->reason) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
<h5 class="mt-4">Rules Followed</h5>
<div class="row">
    <?php foreach ($rules as $rule): ?>
        <div class="col-md-6 mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="rules_followed[]" value="<?= $rule->id ?>" id="rule_<?= $rule->id ?>">
                <label class="form-check-label" for="rule_<?= $rule->id ?>">
                    <?= esc($rule->rule_text) ?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
</div>

      <div class="col-md-12">
        <label for="lesson" class="form-label">📘 Lessons Learned <span class="text-danger">*</span></label>
        <textarea name="lesson" class="form-control" rows="2" required></textarea>
        <div class="invalid-feedback">Please share the lesson learned.</div>
      </div>
    </div>
<div class="col-md-3">
  <label for="self_rating" class="form-label">🌟 Self Rating (1 to 10) <span class="text-danger">*</span></label>
  <input type="number" name="self_rating" id="self_rating" class="form-control" min="1" max="10" required placeholder="e.g. 7">
  <div class="invalid-feedback">Please rate this trade between 1 and 10.</div>
</div>

    <!-- BUTTONS -->
    <div class="mt-4">
      <button type="submit" class="btn btn-success">💾 Save Entry</button>
      <a href="<?= base_url('journal') ?>" class="btn btn-secondary">⬅ Back</a>
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

  const buyInput = document.getElementById('buy_price');
  const sellInput = document.getElementById('sell_price');
  const qtyInput = document.getElementById('qty');
  const pnlInput = document.getElementById('pnl');
  const tradeTypeSelect = document.getElementById('trade_type');

  function calculatePnL() {
    const buy = parseFloat(buyInput.value);
    const sell = parseFloat(sellInput.value);
    const qty = parseInt(qtyInput.value);
    const tradeType = tradeTypeSelect.value;

    if (!isNaN(buy) && !isNaN(sell) && !isNaN(qty)) {
      let pnl = 0;

      if (tradeType === 'Long') {
        pnl = (sell - buy) * qty;
      } else if (tradeType === 'Short') {
        pnl = (buy - sell) * qty;
      }

      pnlInput.value = pnl.toFixed(2);
    } else {
      pnlInput.value = '';
    }
  }

  [buyInput, sellInput, qtyInput, tradeTypeSelect].forEach(input => {
    input.addEventListener('input', calculatePnL);
    input.addEventListener('change', calculatePnL); // for select box
  });


</script>


<?= $this->endSection() ?>
