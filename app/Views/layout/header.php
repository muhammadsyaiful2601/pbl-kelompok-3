<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="<?= base_url('/') ?>" class="nav-link">Home</a>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <?php if (session()->get('logged_in')) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="transition: all 0.2s ease;">
                        <?php $userFoto = session()->get('foto'); ?>
                        <?php if ($userFoto) : ?>
                            <img src="<?= base_url('uploads/user/' . $userFoto) ?>" alt="Foto Profil" class="rounded-circle" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #0ea5e9;">
                        <?php else : ?>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: #0ea5e9; color: white; border: 2px solid #0ea5e9;">
                                <i class="fa-solid fa-user" style="font-size: 1rem;"></i>
                            </div>
                        <?php endif; ?>
                        <span class="d-none d-md-inline fw-medium"><?= session()->get('nama_lengkap') ?></span>
                    </a>
                    <style>
                        .nav-item.dropdown>.nav-link:hover {
                            background-color: #f5f5f5 !important;
                        }
                    </style>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 10px;">
                        <li>
                            <a class="dropdown-item py-2" href="<?= base_url('profile') ?>">
                                <i class="fa-solid fa-user-gear me-2 text-primary"></i>Profil Saya
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                        <li>
                            <a class="dropdown-item py-2 text-danger" href="<?= base_url('logout') ?>">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Keluar
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>