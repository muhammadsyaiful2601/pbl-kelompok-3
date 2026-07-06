<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'WebGIS Sekolah'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">

    <link rel="icon" type="image/svg+xml" href="<?= base_url('gambar/favicon.svg') ?>">
    <link rel="icon" type="image/png" href="<?= base_url('gambar/favicon.png') ?>">
    <link rel="shortcut icon" href="<?= base_url('gambar/favicon.ico') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <?= $this->renderSection('styles') ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <?= $this->include('layout/header') ?>

        <?= $this->include('layout/sidebar') ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0"><?= $page_title ?? 'Dashboard'; ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <?= $this->include('layout/footer') ?>

    </div>

    <script src="<?= base_url('adminlte/js/adminlte.min.js') ?>"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>

</html>