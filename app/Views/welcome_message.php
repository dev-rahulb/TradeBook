<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TradeBook - Your Personal Trading Journal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #e0f7ff, #d0e6f6);
      margin: 0;
      padding: 0;
    }

    .navbar {
      background: transparent;
      padding-top: 1rem;
    }

    .navbar-brand img {
      height: 40px;
    }

    .btn-outline-primary {
      border-radius: 30px;
    }

    .hero {
      padding: 100px 20px 60px;
      text-align: center;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3.2rem;
      color: #2b3a4b;
      line-height: 1.2;
    }

    .hero p {
      font-size: 1.15rem;
      color: #5e6977;
      max-width: 620px;
      margin: 20px auto;
    }

    .hero .btn-primary {
      background: linear-gradient(to right, #6c63ff, #7f72ff);
      border: none;
      padding: 14px 32px;
      font-size: 1rem;
      font-weight: 600;
      border-radius: 30px;
      box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
      transition: all 0.3s ease;
    }

    .hero .btn-primary:hover {
      background: linear-gradient(to right, #5d55e3, #7064f0);
      transform: translateY(-2px);
    }

    .features {
      background: #fff;
      padding: 80px 20px;
      border-radius: 60px 60px 0 0;
      margin-top: 40px;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.04);
    }

    .feature-box {
      text-align: center;
      padding: 30px 20px;
      transition: all 0.3s ease;
    }

    .feature-box img {
      transition: transform 0.3s ease;
    }

    .feature-box:hover img {
      transform: scale(1.1);
    }

    .feature-box h4 {
      font-weight: 600;
      margin-top: 20px;
      color: #2b3a4b;
    }

    .feature-box p {
      font-size: 0.95rem;
      color: #6c7885;
      margin-top: 10px;
    }

    footer {
      text-align: center;
      padding: 24px 10px;
      background: #f3f7fa;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top px-4">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="https://cdn-icons-png.flaticon.com/512/711/711769.png" alt="TradeBook Logo">
      <span class="ms-2 fw-bold text-dark">TradeBook</span>
    </a>
    <div>
      <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary me-2">Login</a>
      <a href="<?= base_url('signup') ?>" class="btn btn-outline-primary">Get Started</a>
    </div>
  </div>
</nav>


  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to TradeBook</h1>
    <p>Track, review, and improve your trading journey. Stay disciplined, journal every trade, and grow smarter with each step.</p>
    <a href="<?= base_url('signup') ?>" class="btn btn-primary mt-3">Start Journaling Now</a>
  </section>

  <!-- Features -->
  <section class="features container">
    <div class="row">
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/2190/2190552.png" width="64" alt="Track Trades">
        <h4>Track Every Trade</h4>
        <p>Log each trade with entry/exit, strategy, mistakes & emotions.</p>
      </div>
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/1006/1006555.png" width="64" alt="Analytics">
        <h4>Analytics & Insights</h4>
        <p>Visualize your win-rate, risk-reward, and trading patterns clearly.</p>
      </div>
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="64" alt="Secure">
        <h4>Simple & Secure</h4>
        <p>Sign up with Gmail and keep your data safe and encrypted.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    © <?= date('Y') ?> TradeBook — Built for Traders, by Traders.
  </footer>

</body>
</html>
