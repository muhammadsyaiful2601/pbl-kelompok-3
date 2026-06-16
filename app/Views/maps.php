<?= $this->extend('layout/template_publik') ?>

<?php
$total_sekolah = $total_sekolah ?? 0;
$total_sd = $total_sd ?? 0;
$total_smp = $total_smp ?? 0;
$total_tk = $total_tk ?? 0;
$sekolah_list = $sekolah_list ?? [];
?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/style-publik.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/search-hero.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-2">

    <section class="hero-section row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                <i class="fa-solid fa-map-location-dot me-1"></i> Sistem Informasi Geografis
            </span>
            <h1 class="display-5 fw-bold text-slate-800 mb-3" style="letter-spacing: -1px; line-height: 1.2;">
                Pemetaan Digital Sekolah <br><span class="text-primary">Jenjang SD, SMP & TK</span>
            </h1>
            <p class="lead text-muted mb-4" style="font-size: 1.05rem;">
                Platform resmi Dinas Pendidikan untuk memantau, menganalisis sebaran geografis, serta pemerataan mutu fasilitas dan akses pendidikan dasar secara akurat, transparan, dan terintegrasi.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="#peta-section" class="btn btn-login px-4 py-2.5 fs-6">
                    <i class="fa-solid fa-earth-asia me-2"></i>Jelajahi Peta Interaktif
                </a>
                <a href="#statistik-section" class="btn btn-outline-secondary px-4 py-2.5 rounded-3 fw-medium bg-white">
                    <i class="fa-solid fa-chart-simple me-2"></i>Lihat Statistik
                </a>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="search-list-container">
                <div class="search-box-wrapper">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="searchSchoolInput" class="form-select border-start-0 ps-0" placeholder="Cari nama atau alamat sekolah..." style="box-shadow: none; border-color: #dee2e6;">
                    </div>
                    <div class="btn-group w-100 shadow-sm p-1 bg-white rounded-3 border" role="group">
                        <button type="button" class="btn btn-sm btn-light active rounded-2 py-1.5 fw-semibold filter-btn" onclick="filterSearchList('semua', this)">Semua</button>
                        <button type="button" class="btn btn-sm btn-light rounded-2 py-1.5 fw-semibold filter-btn" onclick="filterSearchList('SD', this)">SD</button>
                        <button type="button" class="btn btn-sm btn-light rounded-2 py-1.5 fw-semibold filter-btn" onclick="filterSearchList('SMP', this)">SMP</button>
                        <button type="button" class="btn btn-sm btn-light rounded-2 py-1.5 fw-semibold filter-btn" onclick="filterSearchList('TK', this)">TK</button>
                    </div>
                </div>

                <div class="school-table-container">
                    <div class="table-responsive m-0">
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

    <hr class="my-5 opacity-25">

    <section id="statistik-section" class="mb-5 scroll-margin">
        <div class="text-center mb-5">
            <span class="text-primary fw-bold text-uppercase tracking-wider" style="font-size: 0.85rem;">Ikhtisar Data</span>
            <h2 class="fw-bold mt-1">Statistik Pendidikan Terkini</h2>
            <p class="text-muted mx-auto" style="max-width: 500px;">Ringkasan akumulasi data kelembagaan sekolah yang telah diverifikasi dan dipetakan di dalam sistem.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-primary-subtle text-primary rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-school fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_sekolah, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Total Sekolah</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-danger-subtle text-danger rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-children fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_sd, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Dasar (SD)</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-primary-subtle text-primary rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-graduation-cap fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_smp, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Menengah (SMP)</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-info-subtle text-info rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-child-reaching fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1"><?= number_format($total_tk, 0, ',', '.') ?></h3>
                    <p class="text-muted small mb-0 fw-medium">Taman Kanak-kanak (TK)</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-info-subtle text-info rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-user-chalkboard fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">...</h3>
                    <p class="text-muted small mb-0 fw-medium">Data Terverifikasi</p>
                </div>
            </div>
        </div>
    </section>

    <hr class="my-5 opacity-25">

    <section id="peta-section" class="mb-5 scroll-margin">
        <div class="row align-items-center g-4">
            <div class="col-lg-8 order-2 order-lg-1">
                <div id="preview-map"></div>
            </div>
            <div class="col-lg-4 order-1 order-lg-2">
                <span class="text-primary fw-bold text-uppercase tracking-wider" style="font-size: 0.85rem;">Geospasial</span>
                <h2 class="fw-bold mt-1 mb-3">Analisis Sebaran Spasial</h2>
                <p class="text-muted">Visualisasi titik koordinat presisi mempermudah evaluasi jangkauan zonasi, kapasitas daya tampung wilayah, serta validasi lokasi sekolah guna menghindari tumpang tindih area pelayanan.</p>
                <div class="mb-4">
                    <div class="d-flex align-items-start mb-2">
                        <i class="fa-solid fa-circle-check text-success me-2 mt-1"></i>
                        <span>Klasterisasi marker otomatis (SD, SMP, dan TK)</span>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <i class="fa-solid fa-circle-check text-success me-2 mt-1"></i>
                        <span>Informasi popup profil ringkas sekolah</span>
                    </div>
                    <div class="d-flex align-items-start mb-2">
                        <i class="fa-solid fa-circle-check text-success me-2 mt-1"></i>
                        <span>Integrasi peta dasar Google Maps / OpenStreetMap</span>
                    </div>
                </div>
                <a href="<?= base_url('fullmaps') ?>" class="btn btn-outline-primary w-100 py-2.5 fw-semibold rounded-3 shadow-sm bg-white">
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
</script>
<script src="<?= base_url('assets/api/api_maps.js') ?>"></script>

<script>
    // Inisialisasi Peta Utama Publik
    var map = L.map('preview-map').setView([-0.4795, 100.6274], 13);

    // Initial Base Layers
    var baseMaps = {
        "Standard Map": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }),
        "Satellite View": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        })
    };

    // Inject MapTiler layers
    if (typeof window.getMapTilerLayers === 'function') {
        Object.assign(baseMaps, window.getMapTilerLayers());
    }

    // Load saved basemap or default
    var savedBasemap = localStorage.getItem('selectedBasemap') || "Standard Map";
    if (!baseMaps[savedBasemap]) savedBasemap = "Standard Map";

    baseMaps[savedBasemap].addTo(map);

    // Definisi Icon Kustom Leaflet
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

    // Merender marker secara dinamis berdasarkan data PHP
    <?php if (!empty($sekolah_list)): ?>
        <?php foreach ($sekolah_list as $sk): ?>
            <?php if (!empty($sk['latitude'])): ?>
                var iconSekolah = <?= $sk['jenjang'] == 'SD' ? 'redIcon' : ($sk['jenjang'] == 'SMP' ? 'blueIcon' : 'lightblueIcon') ?>;

                var popupContent = `
                    <div class="custom-popup" style="width: 220px;">
                        <img src="<?= $sk['foto'] ? base_url('uploads/sekolah/' . $sk['foto']) : 'https://via.placeholder.com/220x120?text=No+Image' ?>" 
                             style="width: 100%; height: 120px; object-fit: cover; border-radius: 8px 8px 0 0;" class="mb-2">
                        <div class="px-2 pb-2">
                                    <span class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : ($sk['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> mb-1" style="font-size: 10px;"><?= $sk['jenjang'] ?></span>
                            <h6 class="fw-bold mb-1 text-dark"><?= $sk['nama_sekolah'] ?></h6>
                            <p class="text-muted mb-2" style="font-size: 11px; line-height: 1.4;">
                                <i class="fa-solid fa-location-dot me-1"></i> <?= $sk['alamat'] ?>
                            </p>
                            <p class="text-muted mb-2" style="font-size: 11px; line-height: 1.4;">
                                <strong>Akreditasi:</strong> <?= $sk['akreditasi'] ?: 'Belum Terakreditasi' ?>
                            </p>
                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                <small class="text-muted"><i class="fa-solid fa-users me-1"></i> <?= number_format($sk['jumlah_siswa'] ?? 0, 0, ',', '.') ?> Siswa</small>
                                <a href="<?= base_url('sekolah/' . $sk['id_sekolah']) ?>" class="btn btn-xs btn-outline-primary py-0 px-2" style="font-size: 10px;">Detail</a>
                            </div>
                        </div>
                    </div>
                `;

                L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], {
                        icon: iconSekolah
                    })
                    .addTo(map)
                    .bindPopup(popupContent, {
                        maxWidth: 250,
                        className: 'modern-leaflet-popup'
                    });
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    // Render GeoJSON Layers (Wilayah)
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            fetch('<?= base_url($gj['file_geojson']) ?>')
                .then(response => response.json())
                .then(data => {
                    var layer = L.geoJSON(data, {
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
                        .bindPopup("<b>Wilayah:</b> <?= $gj['nama_geojson'] ?>");

                    // Check localStorage for visibility preference (Synced with Full Maps)
                    var isVisible = localStorage.getItem('geojson_vis_<?= $gj['id_geojson'] ?>');
                    if (isVisible === null || isVisible === 'true') {
                        layer.addTo(map);
                    }
                });
        <?php endforeach; ?>
    <?php endif; ?>
</script>
<script src="<?= base_url('assets/js/script-publik.js') ?>"></script>
<script src="<?= base_url('assets/js/search-hero.js') ?>"></script>
<?= $this->endSection() ?>