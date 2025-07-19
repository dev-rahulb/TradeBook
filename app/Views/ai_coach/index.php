<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>
<style>
  pre {
    white-space: pre-wrap;     /* ✅ Allows line wrapping */
    word-wrap: break-word;     /* ✅ Prevents overflow on long words */
    font-family: "Segoe UI", sans-serif;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0;
  }
</style>
<style>
  .truncate-text {
    max-height: 120px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.3s ease;
  }

  .show-full {
    max-height: none;
  }

  .read-more-btn {
    cursor: pointer;
    color: #0d6efd;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-block;
    margin-top: 5px;
  }

  pre {
    white-space: pre-wrap;
    word-wrap: break-word;
    font-family: "Segoe UI", sans-serif;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0;
  }
</style>

<div class="container-fluid px-4">
  <h2 class="mt-4 mb-3 fw-bold text-primary-emphasis">🧠 Weekly AI Coach</h2>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success shadow-sm"><?= session()->getFlashdata('success') ?></div>
  <?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger shadow-sm"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <!-- Week Selector -->
  <form action="<?= base_url('ai-coach/generate') ?>" method="post" class="row g-3 align-items-end mb-4 bg-light p-3 rounded shadow-sm border">
    <div class="col-md-4">
      <label for="week" class="form-label fw-semibold">📅 Select Week</label>
      <select name="week" id="week" class="form-select" required>
        <?php 
          for ($i = 0; $i < 10; $i++): 
            $monday = strtotime("monday this week -$i weeks");
            $sunday = strtotime("+6 days", $monday);
            $label = date('d M', $monday) . ' - ' . date('d M', $sunday);
            if ($i === 0) $label .= ' (This Week)';
            elseif ($i === 1) $label .= ' (Last Week)';
        ?>
          <option value="<?= date('Y-m-d', $monday) ?>">
            <?= $label ?>
          </option>
        <?php endfor; ?>
      </select>
    </div>

    <div class="col-md-3">
      <button type="submit" class="btn btn-primary w-100">
        🧠 Generate for Selected Week
      </button>
    </div>
  </form>

  <!-- Suggestion Cards -->
  <?php foreach ($suggestions as $s): ?>
    <div class="card mb-4 border-start border-4 <?= $s['is_manual'] ? 'border-warning' : 'border-primary' ?> shadow-sm rounded-3">
      <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong class="text-dark fs-6">
          <?= date('d M', strtotime($s['week_start'])) ?> - <?= date('d M', strtotime($s['week_end'])) ?>
        </strong>
        <?php if (!empty($s['performance_score'])): ?>
      <span class="ms-2 badge bg-success">🔢 Score: <?= esc($s['performance_score']) ?>/10</span>
    <?php endif; ?>
        <form action="<?= base_url('ai-coach/delete/'.$s['id']) ?>" method="post" onsubmit="return confirm('Delete this suggestion?')">
          <button class="btn btn-outline-danger btn-sm" title="Delete Suggestion">🗑 Delete</button>
        </form>
      </div>
      <div class="card-body">
    <div class="mb-2 small">
  <div class="truncate-text suggestion-content">
   <?= nl2br(
    preg_replace(
        [
            '/\*\*(.*?)\*\*/',                         // For **bold** sections
            '/^(\d+\.\s.*?):/m'                        // For numbered headings like 1. Title:
        ],
        [
            '<strong>$1</strong>',
            '<strong>$1:</strong>'
        ],
        esc($s['suggestions'])
    )
) ?>

  </div>
  <span class="read-more-btn" onclick="toggleReadMore(this)">Read More</span>
</div>

        <span class="badge bg-<?= $s['is_manual'] ? 'warning text-dark' : 'primary' ?>">
          <?= $s['is_manual'] ? '✍️ Manually Added' : '🤖 AI Generated' ?>
        </span>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<script>
  function toggleReadMore(button) {
    const content = button.previousElementSibling;
    content.classList.toggle('show-full');

    button.textContent = content.classList.contains('show-full') ? 'Show Less' : 'Read More';
  }
</script>

<?= $this->endSection() ?>
