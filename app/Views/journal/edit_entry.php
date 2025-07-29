<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">✏️ Edit Journal Entry</h2>

  <form action="<?= base_url('journal/update/' . $entry->id) ?>" method="post" class="mt-4 needs-validation" novalidate>
    <div class="row g-4">

      <!-- DATE & STOCK -->
      <div class="col-md-3">
        <label for="date" class="form-label">📅 Date <span class="text-danger">*</span></label>
        <input type="date" name="date" class="form-control" value="<?= esc($entry->date) ?>" required>
        <div class="invalid-feedback">Please select a date.</div>
      </div>

      <div class="col-md-3">
        <label for="stock" class="form-label">📈 Stock <span class="text-danger">*</span></label>
        <input type="text" name="stock" class="form-control" value="<?= esc($entry->stock) ?>" required>
        <div class="invalid-feedback">Stock name is required.</div>
      </div>

      <div class="col-md-3">
        <label for="strategy_type" class="form-label">🎯 Strategy Type <span class="text-danger">*</span></label>
        <select name="strategy_type" id="strategy_type" class="form-select" required>
          <option value="" disabled>-- Select Strategy --</option>
          <?php
          $strategies = ['Breakout', 'Reversal', 'Scalping', 'Range Bound', 'News Based', 'Other'];
          foreach ($strategies as $s):
          ?>
            <option value="<?= $s ?>" <?= ($entry->strategy_type === $s) ? 'selected' : '' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Please select a strategy type.</div>
      </div>

      <div class="col-md-3">
        <label for="trade_type" class="form-label">📊 Trade Type <span class="text-danger">*</span></label>
        <select name="trade_type" id="trade_type" class="form-select" required>
          <option value="" disabled>-- Select Type --</option>
          <option value="Long" <?= ($entry->trade_type === 'Long') ? 'selected' : '' ?>>Long (Buy First)</option>
          <option value="Short" <?= ($entry->trade_type === 'Short') ? 'selected' : '' ?>>Short (Sell First)</option>
        </select>
        <div class="invalid-feedback">Please select a trade type.</div>
      </div>

      <!-- BUY/SELL TIME -->
      <div class="col-md-3">
        <label for="buy_time" class="form-label">🕒 Buy Time <span class="text-danger">*</span></label>
        <input type="time" name="buy_time" class="form-control" value="<?= esc($entry->buy_time) ?>" required>
        <div class="invalid-feedback">Buy Time is required.</div>
      </div>

      <div class="col-md-3">
        <label for="sell_time" class="form-label">🕓 Sell Time <span class="text-danger">*</span></label>
        <input type="time" name="sell_time" class="form-control" value="<?= esc($entry->sell_time) ?>" required>
        <div class="invalid-feedback">Sell Time is required.</div>
      </div>

      <!-- PRICES & QTY -->
      <div class="col-md-3">
        <label for="buy_price" class="form-label">💰 Buy Price <span class="text-danger">*</span></label>
        <input type="number" name="buy_price" step="0.01" class="form-control" id="buy_price" value="<?= esc($entry->buy_price) ?>" required>
        <div class="invalid-feedback">Buy Price is required.</div>
      </div>

      <div class="col-md-3">
        <label for="sell_price" class="form-label">💵 Sell Price <span class="text-danger">*</span></label>
        <input type="number" name="sell_price" step="0.01" class="form-control" id="sell_price" value="<?= esc($entry->sell_price) ?>" required>
        <div class="invalid-feedback">Sell Price is required.</div>
      </div>

      <div class="col-md-3">
        <label for="qty" class="form-label">📦 Quantity <span class="text-danger">*</span></label>
        <input type="number" name="qty" class="form-control" id="qty" value="<?= esc($entry->quantity) ?>" required>
        <div class="invalid-feedback">Quantity is required.</div>
      </div>

      <div class="col-md-3">
        <label for="pnl" class="form-label">📊 P&L (₹) <span class="text-danger">*</span></label>
        <input type="number" name="pnl" step="0.01" class="form-control" id="pnl" value="<?= esc($entry->pnl) ?>" readonly required>
        <div class="invalid-feedback">P&L is required.</div>
      </div>

      <!-- STOPLOSS / TARGET / CONFIDENCE -->
      <div class="col-md-3">
        <label for="stop_loss" class="form-label">🛑 Stop Loss <span class="text-danger">*</span></label>
        <input type="number" name="stop_loss" step="0.01" class="form-control" value="<?= esc($entry->stop_loss) ?>" required>
        <div class="invalid-feedback">Stop Loss is required.</div>
      </div>

      <div class="col-md-3">
        <label for="target" class="form-label">🎯 Target <span class="text-danger">*</span></label>
        <input type="number" name="target" step="0.01" class="form-control" value="<?= esc($entry->target) ?>" required>
        <div class="invalid-feedback">Target is required.</div>
      </div>

      <div class="col-md-6">
        <label for="calmness" class="form-label">💡 Confidence Level: <span id="confidenceValue"><?= esc($entry->calmness) ?>%</span></label>
        <input type="range" name="calmness" id="calmness" class="form-range"
               min="0" max="100" step="10" value="<?= esc($entry->calmness) ?>"
               oninput="document.getElementById('confidenceValue').textContent = this.value + '%'">
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

      <div class="col-md-6">
        <label for="mistakes" class="form-label">⚠️ Mistakes (if any)</label>
        <select name="mistake[]" id="mistakes" class="form-select select2" multiple>
          <?php foreach ($mistakes as $mistake): ?>
            <option value="<?= $mistake->id ?>" <?= in_array($mistake->id, $selectedMistakes ?? []) ? 'selected' : '' ?>>
              <?= esc($mistake->reason) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
<h5 class="mt-4">Rules Followed</h5>
<div class="row">
    <?php foreach ($allRules as $rule): ?>
        <div class="col-md-6 mb-2">
            <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="rules_followed[]"
                       value="<?= $rule->id ?>"
                       id="rule_<?= $rule->id ?>"
                       <?= isset($ruleStatusMap[$rule->id]) && $ruleStatusMap[$rule->id] === 'followed' ? 'checked' : '' ?>>
                <label class="form-check-label" for="rule_<?= $rule->id ?>">
                    <?= esc($rule->rule_text) ?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
</div>


      <div class="col-md-6">
        <label for="lesson" class="form-label">📘 Lessons Learned <span class="text-danger">*</span></label>
        <textarea name="lesson" class="form-control" rows="2" required><?= esc($entry->lessons) ?></textarea>
        <div class="invalid-feedback">Please share the lesson learned.</div>
      </div>
    </div>

    <!-- BUTTONS -->
    <div class="mt-4">
      <button type="submit" class="btn btn-success">💾 Update Entry</button>
      <a href="<?= base_url('journal') ?>" class="btn btn-secondary">⬅ Back</a>
    </div>
  </form>
</div>

<!-- JS: Bootstrap validation + Auto P&L -->
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
  input.addEventListener('change', calculatePnL);
});

// Show correct confidence % on load
document.addEventListener("DOMContentLoaded", function () {
  const range = document.getElementById("calmness");
  document.getElementById("confidenceValue").textContent = range.value + '%';
});
</script>

<?= $this->endSection() ?>
