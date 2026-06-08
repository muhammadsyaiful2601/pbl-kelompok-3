<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url('admin/dashboard') ?>" class="brand-link">
            <i class="fa-solid fa-earth-asia text-primary me-2 ms-2"></i>
            <span class="brand-text fw-bold" style="letter-spacing: -0.5px;">WebGIS Sekolah</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-3">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= (url_is('admin/dashboard') ? 'active' : '') ?>">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('admin/sekolah') ?>" class="nav-link <?= (url_is('admin/sekolah*') ? 'active' : '') ?>">
                        <i class="nav-icon fa-solid fa-school"></i>
                        <p>Data Sekolah</p>
                    </a>
                </li>

                <li class="nav-header" style="color: #6c757d; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.5px;">SISTEM</li>

                <li class="nav-item">
                    <a href="<?= base_url('logout') ?>" class="nav-link logout-item-custom" style="color: #ff6b6b !important;">
                        <i class="nav-icon fa-solid fa-right-from-bracket text-danger"></i>
                        <p class="fw-medium">Keluar Sistem</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<style>
    .sidebar-menu .nav-link p {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Efek hover transparan merah untuk tombol logout */
    .logout-item-custom {
        transition: background-color 0.2s ease, color 0.2s ease;
        border-radius: 4px;
        margin: 0 8px;
    }

    .logout-item-custom:hover {
        background-color: rgba(220, 53, 69, 0.15) !important;
        color: #ff8787 !important;
    }
</style>