<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TradeBook - Your Personal Trading Journal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #f5f8ff, #e2efff);
    }

    .navbar {
      background: transparent;
      padding-top: 1rem;
    }

    .navbar-brand img {
      height: 38px;
    }

    .btn-outline-primary, .btn-outline-secondary {
      border-radius: 30px;
      font-weight: 500;
    }

    .hero {
      padding: 120px 20px 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: -50px;
      right: -50px;
      width: 200px;
      height: 200px;
      background: radial-gradient(#cfd7ff, transparent);
      border-radius: 50%;
      z-index: 0;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3.2rem;
      color: #1f2e3c;
      line-height: 1.2;
      z-index: 1;
      position: relative;
    }

    .hero p {
      font-size: 1.15rem;
      color: #5e6977;
      max-width: 620px;
      margin: 20px auto;
      z-index: 1;
      position: relative;
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
      background: #ffffff;
      padding: 100px 20px;
      border-radius: 60px 60px 0 0;
      margin-top: 40px;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.04);
    }

    .feature-box {
      text-align: center;
      padding: 30px 20px;
      transition: all 0.3s ease;
    }

    .feature-box:hover {
      transform: translateY(-5px);
    }

    .feature-box img {
      transition: transform 0.3s ease;
      width: 64px;
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
  <p id="slogan" class="fw-semibold text-muted mt-2"></p>
  <p>Track, review, and improve your trading journey. Stay disciplined, journal every trade, and grow smarter with each step.</p>
  <a href="<?= base_url('signup') ?>" class="btn btn-primary mt-3">Start Journaling Now</a>
</section>

<!-- Features -->
<section class="features container">
  <div class="row">
    <div class="col-md-4 feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/2190/2190552.png" alt="Track Trades">
      <h4>Track Every Trade</h4>
      <p>Log each trade with entry/exit, strategy, mistakes & emotions.</p>
    </div>
    <div class="col-md-4 feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/1006/1006555.png" alt="Analytics">
      <h4>Analytics & Insights</h4>
      <p>Visualize your win-rate, risk-reward, and trading patterns clearly.</p>
    </div>
    <div class="col-md-4 feature-box">
      <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" alt="Secure">
      <h4>Simple & Secure</h4>
      <p>Sign up with Gmail and keep your data safe and encrypted.</p>
    </div>
  </div>
</section>

<!-- Footer -->
<footer>
  © <?= date('Y') ?> TradeBook — Built for Traders, by Traders.
</footer>

<!-- Slogan Rotation Script -->
<script>
  const slogans = [
    "Every Trade Tells a Story.",
    "Track. Learn. Grow.",
    "Discipline Starts with Documentation.",
    "Trade Smart. Reflect Better.",
    "From Chaos to Clarity—Log Every Trade.",
    "Your Journey, Your Journal.",
    "Master the Market, One Entry at a Time."
  ];

  const sloganElement = document.getElementById("slogan");
  const randomIndex = Math.floor(Math.random() * slogans.length);
  sloganElement.textContent = slogans[randomIndex];
</script>

</body>
</html>
