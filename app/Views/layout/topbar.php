<nav class="topbar navbar navbar-expand-lg">
    <div class="container-fluid d-flex justify-content-between align-items-center h-100">

        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-lg-none me-2 p-0 border-0" type="button" id="sidebarToggleBtn" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand d-lg-none d-flex align-items-center p-0" href="<?= base_url('dashboard') ?>">
                <img src="<?= base_url('public/logo.png') ?>" alt="MyTradebook Logo" class="rounded-logo">
                <span class="brand-text d-none d-sm-inline-block">My<span class="green-text">Trade</span>book</span>
            </a>

            <button id="fullscreenToggleDesktop" class="fullscreen-toggle flex-shrink-0 ms-3 d-none d-lg-block" title="Toggle Fullscreen">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>

            <button id="themeToggleDesktop" class="theme-toggle flex-shrink-0 ms-2 d-none d-lg-block" title="Toggle Theme">
                <i class="bi bi-sun-fill"></i>
            </button>
        </div>

        <div class="d-none d-lg-flex align-items-center mx-auto slogan-text">
           <small class="text-body fw-bold fst-italic fs-6"><?= session('slogan') ?? 'Trade with Calm & Clarity' ?></small>
        </div>

        <div class="d-flex align-items-center flex-nowrap ms-auto">

            <button id="fullscreenToggleMobile" class="fullscreen-toggle flex-shrink-0 d-lg-none" title="Toggle Fullscreen">
                <i class="bi bi-arrows-fullscreen"></i>
            </button>

            <button id="themeToggleMobile" class="theme-toggle flex-shrink-0 ms-2 d-lg-none" title="Toggle Theme">
                <i class="bi bi-sun-fill"></i>
            </button>

            <?php $username = session('username') ?? 'Guest'; // Get username from session ?>
            <div class="dropdown ms-3"> <a class="nav-link dropdown-toggle user-profile-info" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> <span class="user-name d-none d-sm-inline-block"> </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><h6 class="dropdown-header"><?= session('user_name') ?></h6></li>
                    <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('settings') ?>">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>