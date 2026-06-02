<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="<?= base_url('/') ?>" class="brand-link">
            <span class="brand-text fw-light">WebGIS Sekolah</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-gauge-high"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('maps') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-map-location-dot"></i>
                        <p>Peta Sebaran Sekolah</p>
                    </a>
                </li>

                <li class="nav-header">MANAJEMEN DATA</li>
                <li class="nav-item">
                    <a href="<?= base_url('sekolah') ?>" class="nav-link">
                        <i class="nav-icon fa-solid fa-school"></i>
                        <p>Data Sekolah</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>