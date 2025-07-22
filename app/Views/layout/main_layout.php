<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'MyTradebook - Your Professional Trading Journal' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="The ultimate trading journal to track, analyze, and elevate your trading performance. Log your trades, find your edge, and achieve consistency with MyTradebook.">

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-bs-theme', savedTheme);
            } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'dark'); // Default to dark
            }
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /* Color Palette Variables */
        :root {
            --bg-body: #131722;
            --bg-navbar: rgba(19, 23, 34, 0.9);
            --bg-card: #1e222d;
            --bg-sidebar: linear-gradient(to bottom, #1b1f3a, #2c2f5a);
            --bg-sidebar-hover: #3a3f70;
            --text-primary: #f0f3f5;
            --text-secondary: #a9b1c2;
            --accent-green: #10b981;
            --accent-red: #ef4444;
            --accent-yellow: #ffc107;
            --border-color: #2a2e39;
            --shadow-color: rgba(0,0,0,0.05);
            --filter-invert: invert(95%) sepia(8%) saturate(143%) hue-rotate(185deg) brightness(108%) contrast(92%);
        }

        html[data-bs-theme="light"] {
            --bg-body: #f8f9fa;
            --bg-navbar: rgba(255, 255, 255, 0.9);
            --bg-card: #ffffff;
            --bg-sidebar: linear-gradient(to bottom, #e2e6ea, #f0f3f5);
            --bg-sidebar-hover: #d3d9df;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --accent-green: #28a745;
            --accent-red: #dc3545;
            --accent-yellow: #ffc107;
            --border-color: #dee2e6;
            --shadow-color: rgba(0,0,0,0.1);
            --filter-invert: none;
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

        .sidebar {
            width: 250px;
            background: var(--bg-sidebar);
            color: var(--text-primary);
            min-height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding-top: 60px;
            transition: all 0.3s ease;
            z-index: 1050;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        .sidebar .logo-section {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
            transition: border-color 0.3s ease;
        }

        .sidebar .navbar-brand {
            color: var(--text-primary);
            text-decoration: none;
        }

        .sidebar .navbar-brand .green-text {
            color: var(--accent-green);
            transition: color 0.3s ease;
        }

        .sidebar a {
            color: var(--text-secondary);
            display: block;
            padding: 14px 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--bg-sidebar-hover);
            border-left: 4px solid var(--accent-yellow);
            color: var(--text-primary);
        }

        .topbar {
            height: 60px;
            background-color: var(--bg-card);
            box-shadow: 0 2px 4px var(--shadow-color);
            padding-left: 15px; /* Default for mobile/tablet */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-right: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background-color 0.3s ease, box-shadow 0.3s ease, padding-left 0.3s ease;
        }

        /* Adjustments for the brand in topbar (mobile only) */
        .topbar .navbar-brand {
            padding: 0 !important;
        }
        .topbar .navbar-brand .brand-text {
            font-weight: bold;
            color: var(--text-primary);
            margin-left: 8px; /* Space between logo and text */
            white-space: nowrap; /* Prevent text wrapping */
        }
        .topbar .navbar-brand .brand-text .green-text {
            color: var(--accent-green);
        }

        .rounded-logo {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Theme Toggle Button Style */
        .theme-toggle, .fullscreen-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.5rem;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            width: 40px;
            height: 40px;
        }
        .theme-toggle:hover, .fullscreen-toggle:hover {
            color: var(--text-primary);
        }

        /* Make Logout button slightly more compact on mobile */
        .btn-sm-compact {
            padding: 0.25rem 0.6rem;
            font-size: 0.8rem;
        }

        /* User Profile Info in Topbar */
        .user-profile-info {
            display: flex;
            align-items: center;
            color: var(--text-primary);
            font-weight: 500;
            margin-right: 15px; /* Space from other right-aligned items */
            white-space: nowrap; /* Prevent user name wrapping */
            overflow: hidden; /* Hide overflow if name is too long */
            text-overflow: ellipsis; /* Add ellipsis if hidden */
        }
        .user-profile-info i {
            font-size: 1.2rem;
            margin-right: 8px;
            color: var(--text-secondary);
        }

        /* Adjust dropdown background/text for themes */
        .dropdown-menu {
            background-color: var(--bg-card);
            border-color: var(--border-color);
        }
        .dropdown-item {
            color: var(--text-primary);
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--bg-sidebar-hover);
            color: var(--text-primary);
        }
        .dropdown-header {
            color: var(--text-secondary);
        }
        .dropdown-divider {
            border-top-color: var(--border-color);
        }


        /* Card styles */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* DataTables specific styling for theme */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-secondary) !important;
            border-color: var(--border-color) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: var(--accent-green) !important;
            color: var(--text-primary) !important;
            border-color: var(--accent-green) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: var(--bg-sidebar-hover) !important;
            color: var(--text-primary) !important;
        }

        .table {
            color: var(--text-primary);
        }
        .table thead {
            color: var(--text-secondary);
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--bg-card);
        }
        .table-hover tbody tr:hover {
            background-color: var(--bg-sidebar-hover);
        }
        .table-bordered, .table-bordered th, .table-bordered td {
            border-color: var(--border-color);
        }

        /* General form control styling for theme consistency */
        .form-control, .form-select {
            background-color: var(--bg-body);
            color: var(--text-primary);
            border-color: var(--border-color);
        }
        .form-control:focus, .form-select:focus {
            background-color: var(--bg-body);
            color: var(--text-primary);
            border-color: var(--accent-green);
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }

        .select2-container .select2-selection--single,
        .select2-container .select2-selection--multiple {
            background-color: var(--bg-body) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
            height: auto !important;
            min-height: 38px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--accent-green) !important;
            color: white !important;
            border: 1px solid var(--accent-green) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: rgba(255,255,255,0.7) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: white !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-primary);
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-top-color: var(--text-secondary) !important;
            border-bottom-color: var(--text-secondary) !important;
        }

        /* Adjust select2 dropdown colors */
        .select2-container--open .select2-dropdown {
            background-color: var(--bg-card) !important;
            border-color: var(--border-color) !important;
        }
        .select2-results__option {
            color: var(--text-primary) !important;
            background-color: var(--bg-card) !important;
        }
        .select2-results__option--highlighted {
            background-color: var(--accent-green) !important;
            color: white !important;
        }
        .select2-search__field {
            background-color: var(--bg-body) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }

        /* Responsive Layout */
        @media (min-width: 992px) { /* Desktop/Laptop view */
            .sidebar {
                left: 0; /* Sidebar always visible */
            }
            .topbar {
                padding-left: 250px; /* Offset for sidebar */
            }
            .main-content {
                margin-left: 250px; /* Offset for sidebar */
                margin-top: 60px; /* Push content down by topbar height */
                padding: 25px;
            }
            /* Hide topbar logo/brand on desktop */
            .topbar .navbar-brand {
                display: none !important;
            }
        }

        @media (max-width: 991.98px) { /* Tablet/Mobile view */
            .sidebar {
                left: -250px; /* Hidden by default off-screen */
            }
            .sidebar.show {
                left: 0; /* Slide in when .show class is added */
            }
            .topbar {
                padding-left: 15px; /* No sidebar offset */
            }
            .main-content {
                margin-left: 0; /* No sidebar offset */
                padding: 15px; /* Adjust padding for smaller screens */
                margin-top: 60px; /* Push content down by topbar height */
            }

            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
                z-index: 1040; /* Below sidebar, above content */
                display: none; /* Hidden by default */
                transition: opacity 0.3s ease;
                opacity: 0;
            }
            .sidebar-backdrop.show {
                display: block; /* Show when sidebar is open */
                opacity: 1;
            }

            /* Adjust topbar elements for smaller screens */
            .topbar .slogan-text { /* Hide slogan on mobile */
                display: none !important;
            }
            /* User profile text hidden on very small screens, only icon shown */
            .user-profile-info .user-name {
                display: none;
            }
            /* More compact logout button on small screens */
            .btn-sm-compact {
                font-size: 0.75rem;
                padding: 0.2rem 0.5rem;
            }
        }

        /* Global responsive utilities for content */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
            margin: auto;
        }

        /* Ensure form groups and inputs are responsive */
        .input-group, .form-control, .form-select, .select2-container {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<div class="sidebar-backdrop"></div>

<?= view('layout/sidebar') ?>

<?= view('layout/topbar') ?>

<div class="main-content">
    <?= $this->renderSection('content') ?>
</div>

<?= view('layout/footer') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<?= $this->section('scripts') ?>

<script>
    $(document).ready(function () {
        // Initialize Select2 dropdowns (if you have them in main_layout)
        $('.select2').select2({
            placeholder: "Select options",
            allowClear: true
        });

        // Initialize DataTables (if you have them in main_layout)
        $('.datatable').DataTable();

        // --- Dark/Light Mode Logic ---
        // Get references to both desktop and mobile theme toggle buttons
        const themeToggleDesktop = document.getElementById('themeToggleDesktop');
        const themeToggleMobile = document.getElementById('themeToggleMobile');
        const htmlElement = document.documentElement; // The <html> tag

        // Function to set the theme attribute on <html> and save to localStorage
        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            updateThemeIcons(theme); // Update icons immediately after setting theme
        }

        // Function to update the icons for both theme toggle buttons
        function updateThemeIcons(currentTheme) {
            // Collect all theme toggle icon elements, filter out any nulls
            const icons = [
                themeToggleDesktop ? themeToggleDesktop.querySelector('i') : null,
                themeToggleMobile ? themeToggleMobile.querySelector('i') : null
            ].filter(icon => icon !== null);

            icons.forEach(icon => {
                if (icon) {
                    if (currentTheme === 'light') {
                        icon.classList.remove('bi-sun-fill');
                        icon.classList.add('bi-moon-fill'); // Show moon icon for light theme
                    } else {
                        icon.classList.remove('bi-moon-fill');
                        icon.classList.add('bi-sun-fill'); // Show sun icon for dark theme
                    }
                }
            });
        }

        // Initialize theme and update icons based on current <html> data-bs-theme attribute
        // This ensures the correct icons are shown on page load
        updateThemeIcons(htmlElement.getAttribute('data-bs-theme'));

        // Add click event listeners to both desktop and mobile theme toggle buttons
        if (themeToggleDesktop) {
            themeToggleDesktop.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });
        }
        if (themeToggleMobile) {
            themeToggleMobile.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });
        }

        // --- Fullscreen Toggle Logic ---
        // Get references to both desktop and mobile fullscreen toggle buttons
        const fullscreenToggleDesktop = document.getElementById('fullscreenToggleDesktop');
        const fullscreenToggleMobile = document.getElementById('fullscreenToggleMobile');

        // Function to handle fullscreen toggling
        function toggleFullscreen() {
            // Collect all fullscreen toggle icon elements
            const icons = [
                fullscreenToggleDesktop ? fullscreenToggleDesktop.querySelector('i') : null,
                fullscreenToggleMobile ? fullscreenToggleMobile.querySelector('i') : null
            ].filter(icon => icon !== null);

            if (!document.fullscreenElement) { // If currently not in fullscreen
                document.documentElement.requestFullscreen().then(() => {
                    // Update icons after successfully entering fullscreen
                    icons.forEach(icon => {
                        if (icon) {
                            icon.classList.remove('bi-arrows-fullscreen');
                            icon.classList.add('bi-fullscreen-exit');
                        }
                    });
                }).catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else { // If currently in fullscreen
                if (document.exitFullscreen) {
                    document.exitFullscreen().then(() => {
                        // Update icons after successfully exiting fullscreen
                        icons.forEach(icon => {
                            if (icon) {
                                icon.classList.remove('bi-fullscreen-exit');
                                icon.classList.add('bi-arrows-fullscreen');
                            }
                        });
                    }).catch(err => {
                        console.error(`Error attempting to exit full-screen mode: ${err.message} (${err.name})`);
                    });
                }
            }
        }

        // Add click event listeners to both desktop and mobile fullscreen toggle buttons
        if (fullscreenToggleDesktop) {
            fullscreenToggleDesktop.addEventListener('click', toggleFullscreen);
        }
        if (fullscreenToggleMobile) {
            fullscreenToggleMobile.addEventListener('click', toggleFullscreen);
        }

        // Listen for browser's native fullscreen change event to keep icons in sync
        document.addEventListener('fullscreenchange', () => {
            // Collect all fullscreen toggle icon elements again
            const icons = [
                fullscreenToggleDesktop ? fullscreenToggleDesktop.querySelector('i') : null,
                fullscreenToggleMobile ? fullscreenToggleMobile.querySelector('i') : null
            ].filter(icon => icon !== null);

            icons.forEach(icon => {
                if (icon) {
                    if (document.fullscreenElement) {
                        // If now in fullscreen
                        icon.classList.remove('bi-arrows-fullscreen');
                        icon.classList.add('bi-fullscreen-exit');
                    } else {
                        // If now exited fullscreen
                        icon.classList.remove('bi-fullscreen-exit');
                        icon.classList.add('bi-arrows-fullscreen');
                    }
                }
            });
        });

        // --- Sidebar Toggle for small screens ---
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
        const sidebar = document.querySelector('.sidebar');
        const sidebarBackdrop = document.querySelector('.sidebar-backdrop');

        function toggleSidebar() {
            if (sidebar && sidebarBackdrop) {
                sidebar.classList.toggle('show');
                sidebarBackdrop.classList.toggle('show');
                document.body.classList.toggle('overflow-hidden'); // Prevents background scroll
            }
        }

        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', toggleSidebar);
        }

        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }

        // Close sidebar if window resized to desktop view while sidebar is open
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992 && sidebar && sidebar.classList.contains('show')) {
                toggleSidebar(); // Close sidebar
            }
        });

    });
</script>

<?= $this->endSection() ?>
<?= $this->renderSection('scripts') ?>

</body>
</html>