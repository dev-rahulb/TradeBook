<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h3>User Management</h3>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Toggle Block</th>
                <th>Toggle Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr class="<?= $user['is_blocked'] ? 'table-danger' : '' ?>">
                    <td><?= $user['id'] ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= $user['role'] ?></td>
                    <td><?= $user['is_blocked'] ? 'Blocked' : 'Active' ?></td>
                    <td>
                        <a href="<?= base_url("admin/toggle-block/{$user['id']}") ?>" class="btn btn-sm <?= $user['is_blocked'] ? 'btn-success' : 'btn-danger' ?>">
                            <?= $user['is_blocked'] ? 'Unblock' : 'Block' ?>
                        </a>
                    </td>
                    <td>
                        <a href="<?= base_url("admin/change-role/{$user['id']}") ?>" class="btn btn-sm btn-secondary">
                            Make <?= $user['role'] === 'admin' ? 'User' : 'Admin' ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
