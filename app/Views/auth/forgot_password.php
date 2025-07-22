<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - MyTradebook.in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="public/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="public/favicon.svg" />
<link rel="shortcut icon" href="public/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="public/apple-touch-icon.png" />
<link rel="manifest" href="public/site.webmanifest" />
    <style>
        /* CSS Variables for colors (Dark Mode Defaults) */
        :root {
            --bg-body: #131722;
            --bg-card: #1e222d;
            --border-color: #2a2e39;
            --text-primary: #f0f3f5;
            --text-secondary: #a9b1c2;
            --accent-green: #10b981;
            --button-action-hover: #059669;
            --form-control-bg: #131722;
            --form-control-border: #2a2e39;
            --form-control-focus-border: #10b981;
            --box-shadow: rgba(0,0,0,0.3);
        }

        /* Light Mode Variables */
        body.light-mode {
            --bg-body: #f8f9fa;
            --bg-card: #ffffff;
            --border-color: #dee2e6;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --accent-green: #28a745;
            --button-action-hover: #218838;
            --form-control-bg: #ffffff;
            --form-control-border: #ced4da;
            --form-control-focus-border: #28a745;
            --box-shadow: rgba(0,0,0,0.1);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            transition: background-color 0.3s ease, color 0.3s ease; /* Smooth transition */
        }

        .forgot-password-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem; /* Default padding for very small screens */
            width: 100%;
            max-width: 420px; /* Consistent max-width for the card */
            box-shadow: 0 10px 30px var(--box-shadow); /* Consistent shadow */
            transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Override default Bootstrap card padding for responsiveness */
        .forgot-password-card.p-4 {
            padding: 1.5rem !important; /* Default from Bootstrap */
        }
        @media (min-width: 576px) { /* Small devices (sm) and up */
            .forgot-password-card.p-sm-5 {
                padding: 3rem !important; /* Larger padding for small and up */
            }
        }

        .forgot-password-card h3 {
            font-weight: 700;
            margin-bottom: 24px;
            text-align: center;
            font-size: 1.8rem;
            color: var(--text-primary); /* Ensure heading color is visible */
            transition: color 0.3s ease;
        }

        .form-label {
            font-weight: 500;
            color: var(--text-secondary); /* Consistent label color */
            transition: color 0.3s ease;
        }

        .form-control {
            background-color: var(--form-control-bg); /* Consistent input background */
            border: 1px solid var(--form-control-border); /* Consistent input border */
            border-radius: 10px;
            color: var(--text-primary); /* Consistent input text color */
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--form-control-focus-border); /* Consistent focus color (green) */
            box-shadow: none;
            background-color: var(--form-control-bg); /* Keep background on focus */
            color: var(--text-primary); /* Keep text color on focus */
        }

        .btn-action {
            background-color: var(--accent-green); /* Consistent button color (green) */
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-action:hover {
            background-color: var(--button-action-hover); /* Consistent button hover color */
            color: #fff; /* Ensure text color remains white on hover */
        }

        .text-link {
            color: var(--text-secondary); /* Default link color */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .text-link:hover {
            color: var(--accent-green); /* Consistent link hover color (green) */
        }

        /* Logo and brand name styling (consistent with login/signup) */
        .logo {
            text-align: center;
            margin-bottom: 24px;
        }

        .logo img {
            height: 48px;
            width: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .logo span {
            margin-left: 10px;
            color: var(--text-primary); /* Ensure logo text changes color */
            transition: color 0.3s ease;
        }

        .green-text {
            color: var(--accent-green); /* Consistent green accent color */
            transition: color 0.3s ease;
        }

        .alert {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="forgot-password-card p-4 p-sm-5">
        <div class="logo d-flex align-items-center justify-content-center mb-4">
            <img src="<?= base_url('public/logo.png') ?>" alt="MyTradebook Logo">
            <span class="fs-5 fw-bold ms-2">My<span class="green-text">Trade</span>book</span>
        </div>

        <h3 class="text-center mb-4">Forgot Password?</h3>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success" role="alert"><?= session('success') ?></div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('forgot-password') ?>">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="Enter your email">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-action">Send OTP</button>
            </div>
        </form>

        <div class="text-center mt-3">
            <small><a href="<?= base_url('login') ?>" class="text-link">Back to Login</a></small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // --- Dark/Light Mode Logic (without a toggle button) ---
    const body = document.body;

    // Function to apply the theme
    function applyTheme(theme) {
        if (theme === 'light-mode') {
            body.classList.add('light-mode');
        } else {
            body.classList.remove('light-mode');
        }
    }

    // 1. Check for saved theme preference in localStorage first
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
        applyTheme(savedTheme);
    } else {
        // 2. If no saved preference, check system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
            applyTheme('light-mode');
        } else {
            // Default to dark mode if no system preference or system prefers dark
            applyTheme('dark-mode');
        }
    }

    // Optional: Listen for system theme changes (if you want it to dynamically update)
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
        if (event.matches) {
            applyTheme('dark-mode');
            localStorage.setItem('theme', 'dark-mode'); // Save preference
        } else {
            applyTheme('light-mode');
            localStorage.setItem('theme', 'light-mode'); // Save preference
        }
    });
</script>
</body>
</html>
