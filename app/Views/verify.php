<?php $email = session('otp_email'); ?>

<form action="<?= base_url('verify') ?>" method="post">
    <!-- Show email if needed -->
    <p><strong>Email:</strong> <?= esc($email) ?></p>

    <!-- Hidden field to send email -->
    <input type="hidden" name="email" value="<?= esc($email) ?>">

    <input type="text" name="otp" placeholder="Enter OTP" required><br>
    <button type="submit">Verify</button>
</form>
