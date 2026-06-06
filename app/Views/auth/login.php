<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login - WebGIS Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            height: 100vh;
        }

        .card-login {
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-sm-8 col-md-6 col-lg-4">

                <div class="card card-login shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            <div class="text-primary mb-2">
                                <i class="fa-solid fa-map-location-dot fs-1"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-1">Panel Admin</h4>
                            <p class="text-muted small">Masuk untuk mengelola data spasial sekolah</p>
                        </div>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger p-2 small border-0 mb-3 text-center" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-1"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('login/process') ?>" method="POST">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label尊 for="username" class="form-label small fw-semibold text-muted">Username</label尊>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="text" name="username" id="username" class="form-control bg-light border-start-0" placeholder="Masukkan username" value="<?= old('username') ?>" required autocomplete="off" style="box-shadow: none;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label small fw-semibold text-muted">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="password" class="form-control bg-light border-start-0" placeholder="Masukkan password" required style="box-shadow: none;">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm text-white">
                                <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk Ke Sistem
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="<?= base_url('/') ?>" class="text-decoration-none small text-muted">
                                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda Publik
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="<?= base_url('adminlte/js/adminlte.min.js') ?>"></script>
</body>

</html>