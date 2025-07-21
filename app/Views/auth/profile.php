<?= $this->extend('layout/main_layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h3>User Profile</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table">
        <tr>
            <th>Name</th>
            <td><?= esc($user['name']) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= esc($user['email']) ?></td>
        </tr>
    </table>

    <a href="<?= base_url('change-password') ?>" class="btn btn-primary">Change Password</a>
</div>

<?= $this->endSection() ?>
