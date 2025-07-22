<div class="sidebar d-flex flex-column position-fixed">
    <div class="text-center logo-section">
        <a class="navbar-brand d-flex flex-column align-items-center" href="<?= base_url('dashboard') ?>">
            <img src="<?= base_url('public/logo.png') ?>" alt="MyTradebook Logo" class="rounded-logo mb-2">
            <span class="fw-bold fs-5" style="color: var(--text-primary);">My<span class="green-text" style="color: var(--accent-green);">Trade</span>book</span>
        </a>
    </div>

    <a href="<?= base_url('dashboard') ?>" class="<?= current_url() == base_url('dashboard') ? 'active' : '' ?>">
        📊 Dashboard
    </a>

    <a href="<?= base_url('journal/calendar') ?>" class="<?= current_url() == base_url('journal/calendar') ? 'active' : '' ?>">
        🗓️ Calendar
    </a>

    <a href="<?= base_url('journal') ?>" class="<?= current_url() == base_url('journal') ? 'active' : '' ?>">
        📓 Journal
    </a>

    <a href="<?= base_url('analytics') ?>" class="<?= current_url() == base_url('analytics') ? 'active' : '' ?>">
        📈 Analytics
    </a>

    <a href="<?= base_url('ai-coach') ?>" class="<?= current_url() == base_url('ai-coach') ? 'active' : '' ?>">
        🧠 AI Coach
    </a>
</div>