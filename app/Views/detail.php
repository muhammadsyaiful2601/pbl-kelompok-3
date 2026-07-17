<?= $this->extend('layout/template_publik') ?>

<?php
$sekolah = $sekolah ?? [
    'foto' => '',
    'nama_sekolah' => '',
    'jenjang' => '',
    'alamat' => '',
    'latitude' => 0,
    'longitude' => 0,
    'akreditasi' => '',
    'deskripsi_sekolah' => '',
    'kepala_sekolah' => '',
    'website' => ''
];
?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    .detail-image-wrapper {
        max-height: 320px;
        overflow: hidden;
    }

    .detail-header-img {
        width: 100%;
        height: 320px;
        object-fit: cover;
    }

    .img-placeholder {
        height: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #detail-map {
        height: 280px;
        border: 1px solid #e2e8f0;
    }

    .back-nav {
        margin-bottom: 25px;
    }

    .back-nav a {
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s;
    }

    .back-nav a:hover {
        color: #2563eb;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .section-title i {
        font-size: 1.2rem;
    }

    .section-body {
        color: #64748b;
        line-height: 1.8;
        font-size: 0.95rem;
    }

    .sidebar-info-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        flex-shrink: 0;
        font-size: 1rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="back-nav">
        <a href="javascript:history.back()">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
        </a>
    </div>

    <div class="row g-4">
        <!-- ========== KOLOM KIRI: Detail Konten ========== -->
        <div class="col-lg-8">
            <div class="shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
                <?php if (!empty($sekolah['foto'])) : ?>
                    <div class="detail-image-wrapper">
                        <img src="<?= base_url('uploads/sekolah/' . $sekolah['foto']) ?>" class="detail-header-img" alt="<?= $sekolah['nama_sekolah'] ?>">
                    </div>
                <?php else : ?>
                    <div class="img-placeholder bg-light">
                        <i class="fa-solid fa-school text-secondary opacity-25 fs-1 mb-2"></i>
                        <span class="text-muted small">Foto belum tersedia</span>
                    </div>
                <?php endif; ?>

                <div class="p-4 p-md-5">
                    <!-- Nama Sekolah + Badge -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                        <span class="badge <?= $sekolah['jenjang'] == 'SD' ? 'bg-danger' : ($sekolah['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> px-3 py-2 rounded-pill">
                            <?= $sekolah['jenjang'] ?>
                        </span>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill text-capitalize">
                            <?= !empty($sekolah['kategori']) ? $sekolah['kategori'] : '-' ?>
                        </span>
                        <?php if (!empty($sekolah['kurikulum'])) : ?>
                            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                <i class="bi bi-book me-1"></i><?= $sekolah['kurikulum'] ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <h1 class="display-6 fw-bold text-dark mb-4"><?= $sekolah['nama_sekolah'] ?></h1>

                    <!-- Info Ringkas 3 Kolom: Akreditasi, Kategori, Kurikulum -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="bg-light rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;"><i class="bi bi-award me-1"></i>Akreditasi</small>
                                <span class="fw-semibold text-dark"><?= $sekolah['akreditasi'] ?: 'Belum Terakreditasi' ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;"><i class="bi bi-tag me-1"></i>Kategori</small>
                                <span class="fw-semibold text-dark text-capitalize"><?= !empty($sekolah['kategori']) ? $sekolah['kategori'] : '-' ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light rounded-3 p-3">
                                <small class="text-muted fw-bold text-uppercase d-block mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;"><i class="bi bi-book me-1"></i>Kurikulum</small>
                                <span class="fw-semibold text-dark"><?= $sekolah['kurikulum'] ?: 'Belum Ada Kurikulum' ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat & Koordinat -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill text-danger mt-1" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Alamat Lengkap</small>
                                    <span class="fw-medium text-dark"><?= $sekolah['alamat'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-pin-map-fill text-primary mt-1" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="text-muted d-block fw-semibold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Koordinat</small>
                                    <span class="fw-medium text-dark"><?= $sekolah['latitude'] ?>, <?= $sekolah['longitude'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Sekolah -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="bi bi-file-text text-primary"></i>
                            Deskripsi Sekolah
                        </div>
                        <div class="section-body">
                            <?= $sekolah['deskripsi_sekolah'] ?: 'Tidak ada deskripsi tersedia untuk sekolah ini.' ?>
                        </div>
                    </div>

                    <!-- Visi -->
                    <?php if (!empty($sekolah['visi'])) : ?>
                        <div class="mb-4">
                            <div class="section-title">
                                <i class="bi bi-eye text-warning"></i>
                                Visi
                            </div>
                            <div class="section-body">
                                <?= nl2br($sekolah['visi']) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Misi -->
                    <?php if (!empty($sekolah['misi'])) : ?>
                        <div class="mb-4">
                            <div class="section-title">
                                <i class="bi bi-list-check text-success"></i>
                                Misi
                            </div>
                            <div class="section-body">
                                <?= nl2br($sekolah['misi']) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ========== KOLOM KANAN: Sidebar Peta & Informasi ========== -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <div class="shadow-sm rounded-4 bg-white p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-map text-primary me-2"></i>Lokasi Geografis
                    </h5>
                    <p class="text-muted small mb-3">Titik koordinat presisi sekolah dalam sistem pemetaan digital.</p>
                    <div id="detail-map" class="rounded-3"></div>

                    <!-- Informasi Tambahan: list-group-flush -->
                    <ul class="list-group list-group-flush mt-4">
                        <?php if (!empty($sekolah['kepala_sekolah'])) : ?>
                            <li class="list-group-item d-flex align-items-center gap-3 px-0 py-3">
                                <div class="sidebar-info-icon bg-info-subtle text-info">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.65rem; line-height: 1.2; letter-spacing: 0.3px;">KEPALA SEKOLAH</small>
                                    <span class="fw-bold text-dark"><?= $sekolah['kepala_sekolah'] ?></span>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($sekolah['tahun_berdiri'])) : ?>
                            <li class="list-group-item d-flex align-items-center gap-3 px-0 py-3">
                                <div class="sidebar-info-icon bg-success-subtle text-success">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.65rem; line-height: 1.2; letter-spacing: 0.3px;">TAHUN BERDIRI</small>
                                    <span class="fw-bold text-dark"><?= $sekolah['tahun_berdiri'] ?></span>
                                </div>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($sekolah['kontak'])) : ?>
                            <li class="list-group-item d-flex align-items-center gap-3 px-0 py-3">
                                <div class="sidebar-info-icon bg-primary-subtle text-primary">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block fw-semibold" style="font-size: 0.65rem; line-height: 1.2; letter-spacing: 0.3px;">KONTAK</small>
                                    <span class="fw-bold text-dark"><?= $sekolah['kontak'] ?></span>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-2 mt-4">
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $sekolah['latitude'] ?>,<?= $sekolah['longitude'] ?>" target="_blank" class="btn btn-primary rounded-pill fw-semibold py-2">
                            <i class="bi bi-signpost-2 me-2"></i>Petunjuk Arah (Google Maps)
                        </a>
                        <?php if (!empty($sekolah['website'])) : ?>
                            <?php $link = preg_match('/^https?:\/\//i', $sekolah['website']) ? $sekolah['website'] : 'https://' . $sekolah['website']; ?>
                            <a href="<?= $link ?>" target="_blank" class="btn btn-outline-success rounded-pill fw-semibold py-2">
                                <i class="bi bi-globe2 me-2"></i>Kunjungi Website Sekolah
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /* Konfigurasi marker icon untuk API Maps */
    window.MAP_CONFIG = {
        markerIcons: {
            SD: '<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>',
            SMP: '<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>',
            TK: '<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>'
        }
    };
</script>
<script src="<?= base_url('assets/api/api_maps.js') ?>"></script>
<script>
    // Inisialisasi Peta Detail
    var lat = <?= $sekolah['latitude'] ?>;
    var lng = <?= $sekolah['longitude'] ?>;
    var zoom = 15;

    var map = L.map('detail-map').setView([lat, lng], zoom);

    // Dynamic Base Layers
    var baseMaps = window.getAllBaseMaps();

    // Load saved basemap or default
    window.loadSavedBasemap(baseMaps, map);

    var markers = {};
    var geojsonLayers = {};
    var geojsonConfig = {}; // For dynamic zoom opacity

    var initialSize = window.getMarkerSize(map.getZoom());
    var iconSekolah = window.createSchoolIcon('<?= addslashes($sekolah['jenjang']) ?>', initialSize);

    var markerSekolah = L.marker([lat, lng], {
            icon: iconSekolah
        }).addTo(map)
        .bindPopup('<b><?= addslashes($sekolah['nama_sekolah']) ?></b><br><small>Akreditasi: <?= addslashes($sekolah['akreditasi'] ?: 'Belum Terakreditasi') ?></small>').openPopup();

    markers[<?= $sekolah['id_sekolah'] ?>] = markerSekolah;

    // Render GeoJSON Layers (Wilayah)
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            window.loadGeoJsonLayer(
                '<?= base_url($gj['file_geojson']) ?>', {
                    color: "#000000",
                    weight: 1.5,
                    opacity: 0.8,
                    fillOpacity: <?= $gj['opacity_geojson'] ?>,
                    fillColor: "<?= $gj['warna_geojson'] ?>"
                },
                "<b>Wilayah:</b> <?= addslashes($gj['nama_geojson']) ?>",
                geojsonLayers,
                geojsonConfig,
                <?= $gj['id_geojson'] ?>,
                map,
                markers
            );
        <?php endforeach; ?>
    <?php endif; ?>

    // Zoom listener
    map.on('zoomend', function() {
        window.updateGeoJsonOpacity(geojsonLayers, geojsonConfig, map.getZoom());
    });
</script>
<?= $this->endSection() ?>