<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - TradeBook</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7ff, #d0e6f6);
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      padding: 30px;
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
    .login-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 1.5rem;
      font-weight: 600;
      color: #4a4a4a;
    }
    .bi-envelope-paper-fill {
      color: #6c63ff;
      font-size: 1.8rem;
    }
  </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="col-md-5">
    <div class="card">
      <div class="login-header mb-4 text-center">
        <i class="bi bi-envelope-paper-fill"></i>
        <span>Forgot Password</span>
      </div>

      <!-- Flash Messages -->
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session('success') ?></div>
      <?php endif; ?>

      <form method="post" action="<?= base_url('forgot-password') ?>">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required placeholder="Enter your email">
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Send OTP</button>
        </div>
      </form>

      <div class="text-center mt-3">
        <small><a href="<?= base_url('login') ?>">Back to Login</a></small>
      </div>
    </div>
  </div>
</div>

</body>
</html>
