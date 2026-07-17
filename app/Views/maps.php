<?= $this->extend('layout/template_publik') ?>

<?php
$total_sekolah = $total_sekolah ?? 0;
$total_sd = $total_sd ?? 0;
$total_smp = $total_smp ?? 0;
$total_tk = $total_tk ?? 0;
$sekolah_list = $sekolah_list ?? [];
?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
<link rel="stylesheet" href="<?= base_url('assets/css/style-publik.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/search-hero.css') ?>">
<style>
    #preview-map {
        height: 400px;
        border: 1px solid #e2e8f0;
    }

    .stat-card-modern {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .lh-relaxed {
        line-height: 1.8;
    }

    .search-table-wrapper {
        max-height: 280px;
        overflow-y: auto;
    }

    .search-table-wrapper::-webkit-scrollbar {
        width: 5px;
    }

    .search-table-wrapper::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }

    .search-table-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .search-table-wrapper::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-2">

    <!-- ==================== HERO SECTION ==================== -->
    <section class="hero-section row align-items-center mb-5 py-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                <i class="fa-solid fa-map-location-dot me-1"></i> Web GIS Geospasial Kabupaten Tanah Datar
            </span>
            <h1 class="display-5 fw-bold text-dark mb-3" style="letter-spacing: -1px; line-height: 1.2;">
                Pusat Informasi Geospasial <br><span class="text-primary">Pendidikan Kabupaten Tanah Datar</span>
            </h1>
            <div class="mb-4" style="max-width: 650px;">
                <p class="lead text-secondary lh-relaxed mb-0" style="text-align: justify;">
                    Platform Web GIS resmi yang menyajikan visualisasi data spasial dan pemetaan sebaran institusi pendidikan dasar secara akurat. Sistem ini dirancang untuk memudahkan pemantauan, analisis aksesibilitas, serta mendukung pengambilan kebijakan strategis berbasis data.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <a href="#peta-section" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill shadow-sm">
                    <i class="fa-solid fa-earth-asia me-2"></i>Jelajahi Peta Interaktif
                </a>
                <a href="#statistik-section" class="btn btn-outline-secondary px-4 py-2 fw-semibold rounded-pill bg-white">
                    <i class="fa-solid fa-chart-simple me-2"></i>Lihat Statistik
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="search-list-container">
                <div class="search-box-wrapper">
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0 text-muted rounded-start-pill">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="searchSchoolInput" class="form-control border-start-0 ps-0" placeholder="Cari nama atau alamat sekolah..." style="box-shadow: none; border-color: #dee2e6;">
                    </div>
                    <div class="btn-group w-100 mb-3" role="group" aria-label="Filter jenjang sekolah">
                        <button type="button" class="btn btn-outline-primary btn-sm active fw-semibold filter-btn" onclick="filterSearchList('semua', this)">Semua</button>
                        <button type="button" class="btn btn-outline-primary btn-sm fw-semibold filter-btn" onclick="filterSearchList('SD', this)">SD</button>
                        <button type="button" class="btn btn-outline-primary btn-sm fw-semibold filter-btn" onclick="filterSearchList('SMP', this)">SMP</button>
                        <button type="button" class="btn btn-outline-primary btn-sm fw-semibold filter-btn" onclick="filterSearchList('TK', this)">TK</button>
                    </div>

                    <div class="filter-kecamatan-wrapper">
                        <select id="filterKecamatanSelect" class="form-select rounded-pill small" style="box-shadow: none; border-color: #dee2e6;" onchange="filterKecamatanList(this.value, true)">
                            <option value="semua">Semua Wilayah</option>
                            <?php if (!empty($active_geojson)) : ?>
                                <?php foreach ($active_geojson as $gj) : ?>
                                    <option value="<?= $gj['id_geojson'] ?>"><?= $gj['nama_geojson'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="school-table-container">
                    <div class="search-table-wrapper">
                        <table class="table table-custom-3d align-middle mb-0" id="schoolSearchTable" style="display: none;">
                            <thead>
                                <tr>
                                    <th scope="col" class="ps-4">Nama Sekolah</th>
                                    <th scope="col">Jenjang</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col" class="text-center pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="schoolSearchListTableBody">
                            </tbody>
                        </table>
                    </div>
                    <div id="schoolListStatus" class="text-center text-muted py-5 small">
                        <i class="fa-solid fa-circle-notch fa-spin me-2"></i>Memuat data sekolah...
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== STATISTIK SECTION ==================== -->
    <section id="statistik-section" class="py-5 mb-4 scroll-margin">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold text-uppercase tracking-wider" style="font-size: 0.85rem;">Ikhtisar Data</span>
            <h2 class="fw-bold mt-1">Statistik Pendidikan Terkini</h2>
            <p class="text-muted mx-auto" style="max-width: 500px;">Ringkasan akumulasi data kelembagaan sekolah yang telah diverifikasi dan dipetakan di dalam sistem.</p>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-3 justify-content-center text-center">
            <div class="col">
                <div class="border-0 shadow-sm rounded-3 p-4 bg-white stat-card-modern h-100">
                    <div class="p-3 bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-school fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_sekolah, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Total Sekolah</p>
                </div>
            </div>
            <div class="col">
                <div class="border-0 shadow-sm rounded-3 p-4 bg-white stat-card-modern h-100">
                    <div class="p-3 bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-children fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_sd, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Dasar (SD)</p>
                </div>
            </div>
            <div class="col">
                <div class="border-0 shadow-sm rounded-3 p-4 bg-white stat-card-modern h-100">
                    <div class="p-3 bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-graduation-cap fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_smp, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Menengah (SMP)</p>
                </div>
            </div>
            <div class="col">
                <div class="border-0 shadow-sm rounded-3 p-4 bg-white stat-card-modern h-100">
                    <div class="p-3 bg-info-subtle text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-child-reaching fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_tk, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Taman Kanak-kanak (TK)</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== PETA SECTION ==================== -->
    <section id="peta-section" class="py-5 mb-4 scroll-margin">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 order-2 order-lg-1">
                <div class="position-relative">
                    <!-- Basemap Switcher Dropdown -->
                    <div class="position-absolute top-0 end-0 m-3" style="z-index: 1000;">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light bg-white shadow-sm rounded-pill px-3 dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="basemapDropdownBtn">
                                <i class="fa-solid fa-layer-group me-1 text-primary"></i> Standar (OSM)
                            </button>
                            <ul class="dropdown-menu shadow-sm border-0 rounded-3 py-2" style="min-width: 200px;" id="basemapDropdownMenu">
                                <li><a class="dropdown-item active small py-2" href="#" data-basemap="Standard Map"><i class="fa-solid fa-map me-2 text-primary"></i> Standar (OSM)</a></li>
                                <li><a class="dropdown-item small py-2" href="#" data-basemap="Satellite View"><i class="fa-solid fa-satellite me-2 text-danger"></i> Satelit (Google)</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item small py-2" href="#" data-basemap="Peta Jalan (MapTiler)"><i class="fa-solid fa-road me-2 text-success"></i> Jalan (MapTiler)</a></li>
                                <li><a class="dropdown-item small py-2" href="#" data-basemap="Peta Jalan Detail (MapTiler)"><i class="fa-solid fa-road me-2 text-success"></i> Jalan Detail (MapTiler)</a></li>
                                <li><a class="dropdown-item small py-2" href="#" data-basemap="Citra Satelit (MapTiler)"><i class="fa-solid fa-globe me-2 text-info"></i> Citra Satelit (MapTiler)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="preview-map" class="rounded-4 shadow-sm"></div>
                </div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                <span class="text-primary fw-bold text-uppercase tracking-wider" style="font-size: 0.85rem;">Geospasial</span>
                <h2 class="fw-bold mt-1 mb-3">Analisis Sebaran Spasial</h2>
                <p class="text-muted" style="text-align: justify;">Visualisasi titik koordinat presisi mempermudah evaluasi jangkauan zonasi, kapasitas daya tampung wilayah, serta validasi lokasi sekolah guna menghindari tumpang tindih area pelayanan.</p>
                <div class="mb-4">
                    <div class="d-flex align-items-start mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                        <span style="text-align: justify;">Klasterisasi marker otomatis (SD, SMP, dan TK)</span>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                        <span style="text-align: justify;">Informasi popup profil ringkas sekolah</span>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                        <span style="text-align: justify;">Integrasi peta dasar Google Maps / OpenStreetMap</span>
                    </div>
                </div>
                <a href="<?= base_url('fullmaps') ?>" class="btn btn-outline-primary w-100 fw-semibold rounded-pill shadow-sm bg-white">
                    <i class="fa-solid fa-expand-arrows-alt me-2"></i>Buka Peta Mode Penuh
                </a>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /* Menyediakan data database ke global runtime javascript */
    window.sekolahData = <?= json_encode($sekolah_list ?? []) ?>;

    /* Konfigurasi marker icon untuk API Maps */
    window.MAP_CONFIG = {
        markerIcons: {
            SD: '<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>',
            SMP: '<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>',
            TK: '<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>'
        }
    };
</script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script src="<?= base_url('assets/api/api_maps.js') ?>"></script>

<script>
    // Inisialisasi Peta Utama Publik
    var map = L.map('preview-map').setView([-0.5059920351014519, 100.74949926873911], 11);

    // Initial Base Layers
    var baseMaps = window.getAllBaseMaps();

    // Load saved basemap or default
    var savedBasemap = window.loadSavedBasemap(baseMaps, map);

    // Basemap Dropdown Handler
    document.querySelectorAll('#basemapDropdownMenu .dropdown-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            var key = this.getAttribute('data-basemap');
            window.switchBasemap(map, baseMaps, key);

            // Update button text
            document.getElementById('basemapDropdownBtn').innerHTML = '<i class="fa-solid fa-layer-group me-1 text-primary"></i> ' + this.textContent.trim();

            // Update active state
            document.querySelectorAll('#basemapDropdownMenu .dropdown-item').forEach(function(el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Global storage for objects
    var markers = {};
    var geojsonLayers = {};
    var geojsonConfig = {}; // Stores original style for dynamic opacity

    // ===== CLUSTER MARKER: SEMUA MARKER WAJIB MASUK CLUSTER =====
    var markerCluster = L.markerClusterGroup({
        chunkedLoading: true,
        maxClusterRadius: 30,
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: false,
        zoomToBoundsOnClick: true,
        disableClusteringAtZoom: 17,
        removeOutsideVisibleBounds: true,
        animate: true,
        animateAddingMarkers: true
    });
    map.addLayer(markerCluster);

    // Merender marker secara dinamis berdasarkan data PHP
    <?php if (!empty($sekolah_list)): ?>
        <?php foreach ($sekolah_list as $sk): ?>
            <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])): ?>
                var initialSize = window.getMarkerSize(map.getZoom());
                var iconSekolah = window.createSchoolIcon('<?= addslashes($sk['jenjang']) ?>', initialSize);

                var popupContent = `<?php ob_start(); ?>
                    <div class="card border-0" style="width: 260px; font-family: 'Plus Jakarta Sans', sans-serif;">
                        <div class="position-relative" style="height: 120px; overflow: hidden; background: #f8f9fa;">
                            <?php if (!empty($sk['foto'])) : ?>
                                <img src="<?= base_url('uploads/sekolah/' . $sk['foto']) ?>" alt="<?= addslashes($sk['nama_sekolah']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else : ?>
                                <div class="img-placeholder bg-light d-flex flex-column align-items-center justify-content-center" style="width:100%;height:100%;">
                                    <i class="fa-solid fa-school text-secondary opacity-25 fs-1 mb-2"></i>
                                    <span class="text-muted small">Foto belum tersedia</span>
                                </div>
                            <?php endif; ?>
                            <span class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : ($sk['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> position-absolute top-0 start-0 m-2 rounded-pill px-2 py-1" style="font-size: 0.65rem; z-index: 5;">
                                <?= addslashes($sk['jenjang']) ?>
                            </span>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;"><?= addslashes($sk['nama_sekolah']) ?></h6>
                            <p class="text-muted small mb-2" style="font-size: 0.75rem; line-height: 1.4;">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i><?= addslashes($sk['alamat']) ?>
                            </p>
                            <div class="row g-0 border-top border-bottom py-2 my-2">
                                <div class="col-6 text-center border-end">
                                    <small class="text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.3px; text-transform: uppercase;">Akreditasi</small>
                                    <span class="fw-semibold text-dark" style="font-size: 0.8rem;"><?= addslashes($sk['akreditasi'] ?: 'Belum Terakreditasi') ?></span>
                                </div>
                                <div class="col-6 text-center">
                                    <small class="text-muted d-block" style="font-size: 0.6rem; letter-spacing: 0.3px; text-transform: uppercase;">Kategori</small>
                                     <span class="fw-semibold text-dark" style="font-size: 0.8rem; text-transform: capitalize;"><?= addslashes(!empty($sk['kategori']) ? $sk['kategori'] : '-') ?></span>
                                </div>
                            </div>
                            <div class="d-grid mt-2">
                                <a href="<?= base_url('sekolah/' . $sk['id_sekolah']) ?>" class="btn btn-primary btn-sm rounded-pill shadow-sm fw-semibold text-white" style="font-size: 0.75rem;">
                                    <i class="bi bi-eye me-1"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php $popupStr = ob_get_clean();
                echo str_replace(["\n", "\r"], '', $popupStr); ?>`;

                var marker = L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], {
                        icon: iconSekolah,
                        originalJenjang: '<?= addslashes($sk['jenjang']) ?>'
                    })
                    .bindPopup(popupContent, {
                        maxWidth: 260,
                        className: 'modern-leaflet-popup'
                    });

                // HANYA TAMBAHKAN KE CLUSTER, JANGAN PERNAH .addTo(map) LANGSUNG!
                markerCluster.addLayer(marker);
                markers[<?= $sk['id_sekolah'] ?>] = marker;
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    // ===== REFRESH CLUSTER: paksa semua marker masuk cluster =====
    setTimeout(function() {
        markerCluster.refreshClusters();
    }, 500);

    // Render GeoJSON Layers (Wilayah)
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            window.loadGeoJsonLayer(
                '<?= base_url($gj['file_geojson']) ?>', {
                    color: "#000000",
                    weight: 2,
                    opacity: 0.8,
                    fillOpacity: <?= $gj['opacity_geojson'] ?>,
                    fillColor: "<?= $gj['warna_geojson'] ?>"
                },
                "<b>Wilayah:</b> <?= addslashes($gj['nama_geojson']) ?>",
                geojsonLayers,
                geojsonConfig,
                <?= $gj['id_geojson'] ?>,
                map,
                null // jangan kirim markersObj karena sudah pakai cluster
            ).then(function(layer) {
                if (layer) {
                    layer.on('click', function(e) {
                        L.DomEvent.stopPropagation(e);
                        filterKecamatanList(<?= $gj['id_geojson'] ?>, false);
                    });
                }

                // Sinkronkan visibility dengan localStorage
                var isVisible = localStorage.getItem('geojson_vis_<?= $gj['id_geojson'] ?>');
                if (isVisible === 'false') {
                    if (geojsonLayers[<?= $gj['id_geojson'] ?>]) {
                        map.removeLayer(geojsonLayers[<?= $gj['id_geojson'] ?>]);
                    }
                }
            });
        <?php endforeach; ?>

        // Sinkronkan marker/cluster dengan visibility layer
        setTimeout(function() {
            // Panggil fungsi filter kecamatan untuk menyesuaikan marker
            if (typeof updateMarkersVisibility === 'function') {
                updateMarkersVisibility();
            }
        }, 300);
    <?php endif; ?>

    // ===== FUNGSI UPDATE MARKER BERDASARKAN LAYER VISIBILITY =====
    window.updateMarkersVisibility = function() {
        var filterFn = function(marker) {
            var latlng = marker.getLatLng();
            var shouldHide = false;

            Object.keys(geojsonLayers).forEach(function(gjId) {
                var isChecked = document.getElementById('toggle_' + gjId);
                var checked = isChecked ? isChecked.checked : true;
                if (!checked) {
                    if (window.isLatLngInLayer(latlng, geojsonLayers[gjId])) {
                        shouldHide = true;
                    }
                }
            });

            return !shouldHide;
        };

        window.updateClusterMarkers(markerCluster, markers, filterFn);
    };

    // Zoom listener
    map.on('zoomend', function() {
        window.updateGeoJsonOpacity(geojsonLayers, geojsonConfig, map.getZoom());
        window.updateMarkerSizes(markers, map.getZoom());
    });
</script>
<script src="<?= base_url('assets/js/script-publik.js') ?>"></script>

<?= $this->endSection() ?>