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
            <div class="card-body py-4 d-flex align-items-center justify-content-between">
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
    <div class="col-12 col-md-4">
        <a href="<?= base_url('superadmin/admin') ?>" class="text-decoration-none">
            <div class="card bg-white shadow-sm border-0 border-start border-4 border-primary h-100">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <p class="small text-muted fw-semibold mb-1">TOTAL ADMIN</p>
                        <h3 class="fw-bold mb-0 text-primary"><?= number_format($total_admin, 0, ',', '.') ?></h3>
                    </div>
                    <i class="fa-solid fa-users-gear text-primary opacity-75 fs-3"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-4">
        <div class="card bg-white shadow-sm border-0 border-start border-4 border-info h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <p class="small text-muted fw-semibold mb-1">TOTAL SEKOLAH</p>
                    <h3 class="fw-bold mb-0 text-info"><?= number_format($total_sekolah, 0, ',', '.') ?></h3>
                </div>
                <i class="fa-solid fa-school text-info opacity-75 fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card bg-white shadow-sm border-0 border-start border-4 border-success h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <p class="small text-muted fw-semibold mb-1">JENJANG SD</p>
                    <h3 class="fw-bold mb-0 text-success"><?= number_format($total_sd, 0, ',', '.') ?></h3>
                </div>
                <i class="fa-solid fa-children text-success opacity-75 fs-3"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
        <div class="card bg-white shadow-sm border-0 border-start border-4 border-warning h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <p class="small text-muted fw-semibold mb-1">JENJANG SMP</p>
                    <h3 class="fw-bold mb-0 text-warning"><?= number_format($total_smp, 0, ',', '.') ?></h3>
                </div>
                <i class="fa-solid fa-graduation-cap text-warning opacity-75 fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card bg-white shadow-sm border-0 border-start border-4 border-info h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <p class="small text-muted fw-semibold mb-1">JENJANG TK</p>
                    <h3 class="fw-bold mb-0 text-info"><?= number_format($total_tk, 0, ',', '.') ?></h3>
                </div>
                <i class="fa-solid fa-child-reaching text-info opacity-75 fs-3"></i>
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
        scrollWheelZoom: true
    }).setView([-0.5278869336553939, 100.76173868221711], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OSM'
    }).addTo(map);

    // Prevent mouse wheel scroll from propagating to the page behind the map
    document.getElementById('map').addEventListener('wheel', function(e) {
        e.stopPropagation();
    }, {
        passive: true
    });

    /**
     * Calculate marker size based on zoom level to avoid overlapping
     */
    function getMarkerSize(zoom) {
        if (zoom >= 17) return {
            w: 65,
            h: 78
        };
        if (zoom >= 15) return {
            w: 50,
            h: 60
        };
        if (zoom >= 13) return {
            w: 38,
            h: 46
        };
        if (zoom >= 11) return {
            w: 28,
            h: 34
        };
        return {
            w: 22,
            h: 27
        };
    }

    /**
     * Create an L.icon for a given jenjang and size
     */
    function createSchoolIcon(jenjang, size) {
        var iconUrl = '<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>';
        if (jenjang === 'SMP') {
            iconUrl = '<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>';
        } else if (jenjang === 'TK') {
            iconUrl = '<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>';
        }
        var w = size.w;
        var h = size.h;
        return L.icon({
            iconUrl: iconUrl,
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [w, h],
            iconAnchor: [w / 2, h],
            popupAnchor: [0, -h + 10],
            shadowSize: [Math.round(w * 0.82), Math.round(h * 0.68)]
        });
    }

    // Render sekolah markers
    <?php if (!empty($sekolah_list)) : ?>
        <?php foreach ($sekolah_list as $sk) : ?>
            <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])) : ?>
                var initialSize = getMarkerSize(map.getZoom());
                var icon = createSchoolIcon('<?= $sk['jenjang'] ?>', initialSize);
                L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], {
                        icon: icon
                    })
                    .addTo(map)
                    .bindPopup("<b><?= $sk['nama_sekolah'] ?></b><br><?= $sk['alamat'] ?>");
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    // Render GeoJSON Layers (Wilayah) - Full Maps Sync
    var geojsonLayers = {};
    var geojsonConfig = {};
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            fetch('<?= base_url($gj['file_geojson']) ?>')
                .then(response => response.json())
                .then(data => {
                    var layer = L.geoJSON(data, {
                            style: function(feature) {
                                return {
                                    color: "#000000", // Black boundary
                                    weight: 2,
                                    opacity: 0.8,
                                    fillOpacity: <?= $gj['opacity_geojson'] ?>,
                                    fillColor: "<?= $gj['warna_geojson'] ?>"
                                };
                            }
                        })
                        .bindPopup("<b>Wilayah:</b> <?= $gj['nama_geojson'] ?>");

                    geojsonLayers[<?= $gj['id_geojson'] ?>] = layer;
                    geojsonConfig[<?= $gj['id_geojson'] ?>] = {
                        fillOpacity: <?= $gj['opacity_geojson'] ?>,
                        opacity: 0.8,
                        color: "#000000"
                    };

                    // Check localStorage for visibility preference (Synced with Full Maps)
                    var isVisible = localStorage.getItem('geojson_vis_<?= $gj['id_geojson'] ?>');
                    if (isVisible === null || isVisible === 'true') {
                        layer.addTo(map);
                    }

                    // Apply initial zoom-based opacity
                    updateGeoJsonOpacity(map.getZoom());
                });
        <?php endforeach; ?>
    <?php endif; ?>

    /**
     * Update GeoJSON opacity based on zoom level
     */
    function updateGeoJsonOpacity(zoom) {
        Object.keys(geojsonLayers).forEach(function(id) {
            var layer = geojsonLayers[id];
            var config = geojsonConfig[id];
            if (!config) return;

            var newFillOpacity = config.fillOpacity;
            var newStrokeOpacity = config.opacity;

            if (zoom >= 17) {
                newFillOpacity = 0.05;
                newStrokeOpacity = 0.15;
            } else if (zoom === 16) {
                newFillOpacity = config.fillOpacity * 0.3;
                newStrokeOpacity = 0.4;
            } else if (zoom === 15) {
                newFillOpacity = config.fillOpacity * 0.6;
                newStrokeOpacity = 0.6;
            }

            layer.setStyle({
                fillOpacity: newFillOpacity,
                opacity: newStrokeOpacity
            });
        });
    }

    // Zoom listener
    map.on('zoomend', function() {
        updateGeoJsonOpacity(map.getZoom());
    });
</script>
<?= $this->endSection() ?>