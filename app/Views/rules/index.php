<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid px-4">
  <h2 class="mt-4">📋 My Trading Rules</h2>

  <div class="d-flex justify-content-end mb-3">
    <a href="<?= base_url('rules/create') ?>" class="btn btn-primary">➕ Add New Rule</a>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Rule</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($rules)): ?>
          <?php foreach ($rules as $index => $rule): ?>
            <tr>
              <td><?= $index + 1 ?></td>
              <td><?= esc($rule['rule_text']) ?></td>
              <td><?= date('d M Y', strtotime($rule['created_at'])) ?></td>
              <td>
                <a href="<?= base_url('rules/edit/' . $rule['id']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                <form action="<?= base_url('rules/delete/' . $rule['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete this rule?')">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-danger">🗑 Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">No rules added yet.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?= $this->endSection() ?>
