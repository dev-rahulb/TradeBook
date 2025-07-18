<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TradeBook - Your Personal Trading Journal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #e0f7ff, #d0e6f6);
      min-height: 100vh;
      margin: 0;
    }

    .hero {
      padding: 80px 20px;
      text-align: center;
    }

    .hero h1 {
      font-weight: 700;
      font-size: 3rem;
      color: #35495e;
    }

    .hero p {
      font-size: 1.2rem;
      color: #5e6977;
      max-width: 600px;
      margin: 20px auto;
    }

    .hero .btn-primary {
      background-color: #6c63ff;
      border: none;
      padding: 12px 28px;
      font-size: 1rem;
      border-radius: 30px;
    }

    .hero .btn-primary:hover {
      background-color: #594ddd;
    }

    .navbar-brand img {
      height: 40px;
    }

    .features {
      background: white;
      padding: 60px 20px;
      border-radius: 40px 40px 0 0;
      box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.05);
    }

    .feature-box {
      text-align: center;
      padding: 20px;
    }

    .feature-box h4 {
      color: #35495e;
      margin-top: 15px;
    }

    .feature-box p {
      color: #5e6977;
      font-size: 0.95rem;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #f3f7fa;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light bg-transparent px-4 pt-3">
    <a class="navbar-brand" href="#">
      <img src="https://cdn-icons-png.flaticon.com/512/711/711769.png" alt="TradeBook Logo">
      <span class="ms-2 fw-bold text-dark">TradeBook</span>
    </a>
    <a href="<?= base_url('signup') ?>" class="btn btn-outline-primary">Get Started</a>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to TradeBook</h1>
    <p>The easiest way to track, review, and improve your trading performance. Stay disciplined, journal every trade, and grow with confidence.</p>
    <a href="<?= base_url('signup') ?>" class="btn btn-primary mt-3">Start Journaling Now</a>
  </section>

  <!-- Features -->
  <section class="features container">
    <div class="row">
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/2190/2190552.png" width="64">
        <h4>Track Every Trade</h4>
        <p>Log entries with strategy, emotions, result & screenshots.</p>
      </div>
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/1006/1006555.png" width="64">
        <h4>Analytics & Insights</h4>
        <p>See your win-rate, average profit/loss and patterns clearly.</p>
      </div>
      <div class="col-md-4 feature-box">
        <img src="https://cdn-icons-png.flaticon.com/512/833/833472.png" width="64">
        <h4>Simple & Secure</h4>
        <p>Start with your Gmail. Your data stays safe & private.</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    © <?= date('Y') ?> TradeBook — Built for Traders, by Traders.
  </footer>

</body>
</html>