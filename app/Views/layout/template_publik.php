<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'WebGIS Sekolah'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            overflow-x: hidden;
        }

        /* Navbar Glassmorphism Effect */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.85) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 1030;
        }

        .navbar-custom .navbar-brand {
            color: #1e293b !important;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .navbar-custom .navbar-brand i {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link-custom {
            color: #64748b !important;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: #3b82f6 !important;
        }

        /* Button Login Modern */
        .btn-login {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff !important;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        /* Footer Mini & Clean */
        .footer-custom {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Main Content Wrapper */
        .content-wrapper-gis {
            min-height: calc(100vh - 70px - 60px);
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="hold-transition">

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('/') ?>">
                <i class="fa-solid fa-map-location-dot fs-4 me-2"></i>
                <span>Web<span class="text-primary">GIS</span> Sekolah</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="<?= base_url('/') ?>">
                            <i class="fa-solid fa-house me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#statistik-section">
                            <i class="fa-solid fa-chart-simple me-1"></i> Statistik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#peta-section">
                            <i class="fa-solid fa-earth-asia me-1"></i> Peta Interaktif
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <div class="content-wrapper-gis">
        <div class="container-fluid px-4">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <footer class="footer-custom py-3 text-center">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-2 mb-md-0">
                <strong>&copy; 2026 PBL Kelompok 3</strong> - Sistem Informasi Geografis Sekolah.
            </div>
            <div class="text-muted" style="font-size: 0.85rem;">
                Dibuat dengan <i class="fa-solid fa-heart text-danger"></i> untuk Pendidikan Indonesia
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('adminlte/js/adminlte.min.js') ?>"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>