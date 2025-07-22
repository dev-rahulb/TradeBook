<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyTradebook.in - Your Professional Trading Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The ultimate trading journal to track, analyze, and elevate your trading performance. Log your trades, find your edge, and achieve consistency with MyTradebook.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="icon" type="image/png" href="public/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="public/favicon.svg" />
<link rel="shortcut icon" href="public/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="public/apple-touch-icon.png" />
<link rel="manifest" href="public/site.webmanifest" />
    <style>
        /*
        COLOR PALETTE (Dark Mode Defaults)
        --bg-dark: #131722; (TradingView Dark)
        --bg-card: #1e222d;
        --text-primary: #f0f3f5;
        --text-secondary: #a9b1c2;
        --accent-green: #10b981; (Profit Green)
        --accent-red: #ef4444;   (Loss Red)
        --border-color: #2a2e39;
        */

        :root {
            --bg-body: #131722;
            --bg-navbar: rgba(19, 23, 34, 0.8);
            --bg-card: #1e222d;
            --text-primary: #f0f3f5;
            --text-secondary: #a9b1c2;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --border-color: #2a2e39;
            --button-outline-hover-bg: #1e222d;
            --button-outline-hover-color: #f0f3f5;
            --button-outline-hover-border: #a9b1c2;
            --button-success-hover-bg: #059669;
            --button-success-shadow: rgba(16, 185, 129, 0.2);
            --button-success-hover-shadow: rgba(16, 185, 129, 0.3);
            --hero-gradient: rgba(16, 185, 129, 0.08);
            --feature-box-hover-border: #10b981;
            --feature-box-hover-shadow: rgba(0,0,0,0.2);
            --filter-invert: invert(95%) sepia(8%) saturate(143%) hue-rotate(185deg) brightness(108%) contrast(92%);
        }

        body.light-mode {
            --bg-body: #f8f9fa;
            --bg-navbar: rgba(255, 255, 255, 0.8);
            --bg-card: #ffffff;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --accent-green: #28a745;
            --accent-red: #dc3545;
            --border-color: #dee2e6;
            --button-outline-hover-bg: #e9ecef;
            --button-outline-hover-color: #212529;
            --button-outline-hover-border: #adb5bd;
            --button-success-hover-bg: #218838;
            --button-success-shadow: rgba(40, 167, 69, 0.2);
            --button-success-hover-shadow: rgba(40, 167, 69, 0.3);
            --hero-gradient: rgba(40, 167, 69, 0.08);
            --feature-box-hover-border: #28a745;
            --feature-box-hover-shadow: rgba(0,0,0,0.1);
            --filter-invert: none; /* No inversion needed for light icons */
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navbar {
            background: var(--bg-navbar);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 8px;
        }

        .navbar-brand span {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--text-primary);
            transition: color 0.3s ease;
        }

        .navbar-brand .green-text {
            color: var(--accent-green);
            transition: color 0.3s ease;
        }

        .btn-outline-secondary {
            border-color: var(--border-color);
            color: var(--text-secondary);
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        .btn-outline-secondary:hover {
            background-color: var(--button-outline-hover-bg);
            color: var(--button-outline-hover-color);
            border-color: var(--button-outline-hover-border);
        }

        .btn-success {
            background-color: var(--accent-green);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 20px;
            box-shadow: 0 4px 15px var(--button-success-shadow);
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background-color: var(--button-success-hover-bg);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--button-success-hover-shadow);
        }

        .hero {
            padding: 140px 20px 80px;
            text-align: center;
            position: relative;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 500px;
            background: radial-gradient(circle, var(--hero-gradient), transparent 70%);
            z-index: 0;
            pointer-events: none;
            transition: background 0.3s ease;
        }

        .hero h1 {
            font-weight: 700;
            font-size: 3.5rem;
            color: var(--text-primary);
            line-height: 1.2;
            z-index: 1;
            position: relative;
            transition: color 0.3s ease;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 650px;
            margin: 20px auto;
            z-index: 1;
            position: relative;
            transition: color 0.3s ease;
        }

        .hero .btn-lg {
            padding: 16px 40px;
            font-size: 1.1rem;
        }

        .features {
            padding: 80px 20px;
        }

        h2.section-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 50px;
            color: var(--text-primary);
            transition: color 0.3s ease;
        }

        .feature-box {
            background-color: var(--bg-card);
            text-align: center;
            padding: 40px 30px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            border-color: var(--feature-box-hover-border);
            box-shadow: 0 10px 30px var(--feature-box-hover-shadow);
        }

        .feature-box img {
            width: 64px;
            margin-bottom: 20px;
            filter: var(--filter-invert); /* Apply filter based on mode */
            transition: filter 0.3s ease;
        }

        .feature-box h4 {
            font-weight: 600;
            color: var(--text-primary);
            transition: color 0.3s ease;
        }

        .feature-box p {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.6;
            transition: color 0.3s ease;
        }

        footer {
            text-align: center;
            padding: 30px 10px;
            background-color: var(--bg-card);
            border-top: 1px solid var(--border-color);
            margin-top: 60px;
            font-size: 0.9rem;
            color: var(--text-secondary);
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
        .rounded-logo {
            height: 42px;
            width: 42px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Dark/Light Mode Toggle Button Style */
        .theme-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 15px;
            transition: color 0.3s ease;
        }
        .theme-toggle:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="public/logo.png" alt="MyTradebook Logo" class="rounded-logo">
            <span style="margin-left: 12px;">My<span class="green-text">Trade</span>book</span>
        </a>
        <div class="d-flex align-items-center">
            <a href="<?= base_url('login') ?>" class="btn btn-outline-secondary me-2">Login</a>
            <a href="<?= base_url('signup') ?>" class="btn btn-success me-2">Get Started Free</a>
            <button id="themeToggle" class="theme-toggle">
                <i class="bi bi-sun-fill"></i> </button>
        </div>
    </div>
</nav>

<section class="hero">
    <div class="container position-relative">
        <h1>Master Your Trading Psychology</h1>
        <p id="slogan" class="fw-semibold mt-3 mb-4"></p>
        <p class="lead">The professional journal to track your trades, analyze your performance, and find your winning edge. Stop guessing, start improving.</p>
        <a href="<?= base_url('signup') ?>" class="btn btn-success btn-lg mt-4">Start Journaling in 60 Seconds</a>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Everything You Need to Become a Profitable Trader</h2>
        <div class="row g-4 mt-4">
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="feature-box">
                    <img src="https://cdn-icons-png.flaticon.com/512/2936/2936744.png" alt="Track Trades">
                    <h4>Log Trades Intelligently</h4>
                    <p>Record every detail, from entry and exit points to setups, mistakes, and emotions. Attach charts to review your execution.</p>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="feature-box">
                    <img src="https://cdn-icons-png.flaticon.com/512/4504/4504815.png" alt="Analytics">
                    <h4>Powerful Analytics</h4>
                    <p>Get actionable insights with dashboards that visualize your win rate, risk-to-reward ratio, best-performing strategies, and more.</p>
                </div>
            </div>
            <div class="col-lg-4 d-flex align-items-stretch">
                <div class="feature-box">
                    <img src="https://cdn-icons-png.flaticon.com/512/5028/5028994.png" alt="Secure">
                    <h4>Private & Secure</h4>
                    <p>Your trading data is your biggest asset. We keep it safe with end-to-end encryption. Your journal is for your eyes only.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<footer>
    © <?= date('Y') ?> MyTradebook.in — Built by Traders, for Traders.
</footer>

<script>
    const slogans = [
        "From Chaos to Clarity—Log Every Trade.",
        "Track. Analyze. Improve. Repeat.",
        "Discipline is Your Bridge to Profitability.",
        "Trade Smarter, Not Harder.",
        "Your Edge is in Your Data.",
        "Master the Market, One Trade at a Time."
    ];

    const sloganElement = document.getElementById("slogan");
    let index = Math.floor(Math.random() * slogans.length);

    function fadeSlogan() {
        sloganElement.style.opacity = 0;
        setTimeout(() => {
            index = (index + 1) % slogans.length;
            sloganElement.textContent = slogans[index];
            sloganElement.style.opacity = 1;
        }, 500); // fade out time
    }

    // Set initial slogan
    sloganElement.textContent = slogans[index];
    sloganElement.style.opacity = 1;

    // Change slogan every 4 seconds
    setInterval(fadeSlogan, 4000);

    // --- Dark/Light Mode Logic ---
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    // Check for saved theme preference or system preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        body.classList.add(savedTheme);
        updateThemeIcon(savedTheme);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
        // Default to light mode if system prefers it
        body.classList.add('light-mode');
        updateThemeIcon('light-mode');
    } else {
        // Default to dark mode
        updateThemeIcon('dark-mode');
    }

    themeToggle.addEventListener('click', () => {
        if (body.classList.contains('light-mode')) {
            body.classList.remove('light-mode');
            localStorage.setItem('theme', 'dark-mode');
            updateThemeIcon('dark-mode');
        } else {
            body.classList.add('light-mode');
            localStorage.setItem('theme', 'light-mode');
            updateThemeIcon('light-mode');
        }
    });

    function updateThemeIcon(currentTheme) {
        const icon = themeToggle.querySelector('i');
        if (currentTheme === 'light-mode') {
            icon.classList.remove('bi-sun-fill');
            icon.classList.add('bi-moon-fill'); // Moon icon for light mode
        } else {
            icon.classList.remove('bi-moon-fill');
            icon.classList.add('bi-sun-fill'); // Sun icon for dark mode
        }
    }
</script>

</body>
</html>