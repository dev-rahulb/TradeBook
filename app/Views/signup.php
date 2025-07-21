<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up - TradeBook</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7ff, #d0e6f6);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-primary {
      background-color: #6c63ff;
      border: none;
      border-radius: 10px;
    }
    .btn-primary:hover {
      background-color: #594ddd;
    }
  </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="col-md-6">
    <div class="card p-4">
      <h3 class="text-center mb-4">Create Your TradeBook Account</h3>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session('error') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session('success') ?></div>
<?php endif; ?>

      <!-- ✅ Show OTP form -->
      <?php if (session()->getFlashdata('showOtpForm')): ?>
        <form action="<?= base_url('verify') ?>" method="post">
          <input type="hidden" name="email" value="<?= session('signup_email') ?>">
          <div class="mb-3">
            <label>Enter OTP sent to <?= session('signup_email') ?></label>
            <input type="text" name="otp" class="form-control" required placeholder="Enter OTP">
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Verify OTP</button>
          </div>
        </form>

      <!-- ✨ Show Signup Form by default -->
      <?php else: ?>
        <form action="<?= base_url('signup') ?>" method="post">
          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required placeholder="Your full name">
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required placeholder="you@example.com">
          </div>
          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Create a password">
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Sign Up</button>
          </div>
        </form>

        <!-- Forgot Password link -->
<div class="text-center mt-2">
  <a href="<?= base_url('forgot-password') ?>" class="text-decoration-none">Forgot Password?</a>
</div>

      <?php endif; ?>

      <div class="text-center mt-3">
        <small>Already have an account? <a href="<?= base_url('login') ?>">Login</a></small>
      </div>
    </div>
  </div>
</div>

</body>
</html>
