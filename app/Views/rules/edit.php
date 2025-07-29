<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">✏️ Edit Rule</h2>

  <form action="<?= base_url('rules/update/' . $rule['id']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
      <label for="rule_text" class="form-label">Rule Description</label>
      <textarea name="rule_text" id="rule_text" rows="4" class="form-control"><?= old('rule_text', $rule['rule_text']) ?></textarea>
      <?php if (isset($validation) && $validation->hasError('rule_text')): ?>
        <div class="text-danger mt-1"><?= $validation->getError('rule_text') ?></div>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">💾 Update Rule</button>
    <a href="<?= base_url('rules') ?>" class="btn btn-secondary">↩️ Cancel</a>
  </form>
</div>

<?= $this->endSection() ?>
