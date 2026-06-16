<?= $this->extend('layout/template') ?>

<?php
$total_admin = $total_admin ?? 0;
$total_sekolah = $total_sekolah ?? 0;
$total_sd = $total_sd ?? 0;
$total_smp = $total_smp ?? 0;
$total_tk = $total_tk ?? 0;
$sekolah_list = $sekolah_list ?? [];
?>

<?= $this->section('styles') ?>
<!-- CDN CSS for Spasial Features -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .modern-stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none !important;
        cursor: pointer;
    }

    .modern-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .stat-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.15;
        transform: rotate(-15deg);
    }

    #map {
        border-radius: 8px;
        border: 1px solid #eef2f6;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- ROW 1: WELCOME BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); border-left: 5px solid #6366f1 !important; border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        Panel <span class="text-indigo">Super Admin</span>, <span class="text-primary"><?= session()->get('nama_lengkap') ?></span>!
                    </h5>
                    <p class="text-muted small mb-0">Manajemen tingkat tinggi untuk Administrasi Sistem dan Data Sekolah.</p>
                </div>
                <div class="d-none d-md-block fs-3 text-indigo opacity-25">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ROW 2: INFO CARDS -->
<div class="row g-3 mb-4">
    <!-- Total Admin -->
    <div class="col-12 col-md-3">
        <a href="<?= base_url('superadmin/admin') ?>" class="text-decoration-none">
            <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #6366f1, #4f46e5); border-radius: 15px;">
                <div class="card-body p-4 text-center text-md-start">
                    <p class="small text-white-50 fw-bold mb-1">TOTAL ADMIN</p>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_admin, 0, ',', '.') ?></h2>
                    <div class="stat-icon-bg"><i class="fa-solid fa-users-gear"></i></div>
                </div>
            </div>
        </a>
    </div>
    <!-- Total Sekolah -->
    <div class="col-12 col-md-3">
        <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #3b82f6, #2563eb); border-radius: 15px;">
            <div class="card-body p-4 text-center text-md-start">
                <p class="small text-white-50 fw-bold mb-1">TOTAL SEKOLAH</p>
                <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_sekolah, 0, ',', '.') ?></h2>
                <div class="stat-icon-bg"><i class="fa-solid fa-school"></i></div>
            </div>
        </div>
    </div>
    <!-- SD -->
    <div class="col-12 col-md-3">
        <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #10b981, #059669); border-radius: 15px;">
            <div class="card-body p-4 text-center text-md-start">
                <p class="small text-white-50 fw-bold mb-1">JENJANG SD</p>
                <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_sd, 0, ',', '.') ?></h2>
                <div class="stat-icon-bg"><i class="fa-solid fa-children"></i></div>
            </div>
        </div>
    </div>
    <!-- SMP -->
    <div class="col-12 col-md-3">
        <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #f59e0b, #d97706); border-radius: 15px;">
            <div class="card-body p-4 text-center text-md-start">
                <p class="small text-white-50 fw-bold mb-1">JENJANG SMP</p>
                <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_smp, 0, ',', '.') ?></h2>
                <div class="stat-icon-bg"><i class="fa-solid fa-graduation-cap"></i></div>
            </div>
        </div>
    </div>
    <!-- TK -->
    <div class="col-12 col-md-3">
        <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #38bdf8, #0ea5e9); border-radius: 15px;">
            <div class="card-body p-4 text-center text-md-start">
                <p class="small text-white-50 fw-bold mb-1">JENJANG TK</p>
                <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_tk, 0, ',', '.') ?></h2>
                <div class="stat-icon-bg"><i class="fa-solid fa-child-reaching"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Mini Map -->
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-map-marked-alt text-primary me-2"></i>Visualisasi Sebaran Sekolah</h6>
            </div>
            <div class="card-body p-4">
                <div id="map" style="height: 400px; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- CDN JS for Spasial & Analytics -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initializing Mini Map
    var map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: false
    }).setView([-0.4795, 100.6274], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OSM'
    }).addTo(map);

    // Icon definitions
    var redIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    var blueIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    var lightblueIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    // Render sekolah markers
    <?php if (!empty($sekolah_list)) : ?>
        <?php foreach ($sekolah_list as $sk) : ?>
            <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])) : ?>
                var icon = '<?= $sk['jenjang'] ?>' === 'SD' ? redIcon : ('<?= $sk['jenjang'] ?>' === 'SMP' ? blueIcon : lightblueIcon);
                L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], {
                        icon: icon
                    })
                    .addTo(map)
                    .bindPopup("<b><?= $sk['nama_sekolah'] ?></b><br><?= $sk['alamat'] ?>");
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    // Render GeoJSON Layers (Wilayah)
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            fetch('<?= base_url($gj['file_geojson']) ?>')
                .then(response => response.json())
                .then(data => {
                    L.geoJSON(data, {
                            style: function(feature) {
                                return {
                                    color: "<?= $gj['warna_geojson'] ?>",
                                    weight: 2,
                                    opacity: 0.6,
                                    fillOpacity: <?= $gj['opacity_geojson'] ?>,
                                    fillColor: "<?= $gj['warna_geojson'] ?>"
                                };
                            }
                        })
                        .bindPopup("<b>Wilayah:</b> <?= $gj['nama_geojson'] ?>")
                        .addTo(map);
                });
        <?php endforeach; ?>
    <?php endif; ?>
</script>
<?= $this->endSection() ?>