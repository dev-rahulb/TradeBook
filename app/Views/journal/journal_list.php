<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<div class="container-fluid px-4">
  <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h2>📒 Journal Entries</h2>
    <a href="<?= base_url('journal/create') ?>" class="btn btn-primary">+ Add Entry</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table id="journalTable" class="table table-bordered table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Date</th>
            <th>Stock</th>
           
            
            <th>P&L (₹)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($entries)): ?>
            <?php foreach ($entries as $entry): ?>
              <tr>
                <td><?= esc($entry['date']) ?></td>
                <td><?= esc($entry['stock']) ?></td>
          
                <td><?= esc($entry['pnl']) ?></td>
                <td>
                  <a href="<?= base_url('journal/edit/'.$entry['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                  <a href="<?= base_url('journal/delete/'.$entry['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">No journal entries found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTable Initialization -->
<script>
  $(document).ready(function () {
    $('#journalTable').DataTable({
      "order": [[0, "desc"]],
      "pageLength": 10,
      "lengthMenu": [5, 10, 25, 50],
      "language": {
        "search": "🔍 Search:",
        "lengthMenu": "Show _MENU_ entries",
        "zeroRecords": "No matching records",
        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
        "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)"
      }
    });
  });
</script>

<?= $this->endSection() ?>
