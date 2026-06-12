<?= $this->extend('layout/template') ?>

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
    .table-custom th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #64748b;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- ROW 1: WELCOME BANNER -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%); border-left: 5px solid #3b82f6 !important; border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        Selamat Datang, <span class="text-primary"><?= session()->get('nama_lengkap') ?></span>!
                    </h5>
                    <p class="text-muted small mb-0">Panel kendali pusat untuk manajemen data spasial dan infrastruktur pendidikan.</p>
                </div>
                <div class="d-none d-md-block fs-3 text-primary opacity-25">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ROW 2: INFO CARDS -->
<div class="row g-3 mb-4">
    <!-- Total Sekolah -->
    <div class="col-12 col-md-4">
        <a href="<?= base_url('admin/sekolah') ?>" class="text-decoration-none">
            <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #3b82f6, #2563eb); border-radius: 15px;">
                <div class="card-body p-4 text-center text-md-start">
                    <p class="small text-white-50 fw-bold mb-1">TOTAL SEKOLAH</p>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_sekolah, 0, ',', '.') ?></h2>
                    <div class="stat-icon-bg"><i class="fa-solid fa-school"></i></div>
                </div>
            </div>
        </a>
    </div>
    <!-- SD -->
    <div class="col-12 col-sm-6 col-md-4">
        <a href="<?= base_url('admin/sekolah') ?>" class="text-decoration-none">
            <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #10b981, #059669); border-radius: 15px;">
                <div class="card-body p-4 text-center text-md-start">
                    <p class="small text-white-50 fw-bold mb-1">JENJANG SD</p>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_sd, 0, ',', '.') ?></h2>
                    <div class="stat-icon-bg"><i class="fa-solid fa-children"></i></div>
                </div>
            </div>
        </a>
    </div>
    <!-- SMP -->
    <div class="col-12 col-sm-6 col-md-4">
        <a href="<?= base_url('admin/sekolah') ?>" class="text-decoration-none">
            <div class="card modern-stat-card h-100 shadow-sm text-white" style="background: linear-gradient(45deg, #f59e0b, #d97706); border-radius: 15px;">
                <div class="card-body p-4 text-center text-md-start">
                    <p class="small text-white-50 fw-bold mb-1">JENJANG SMP</p>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.5rem;"><?= number_format($total_smp, 0, ',', '.') ?></h2>
                    <div class="stat-icon-bg"><i class="fa-solid fa-graduation-cap"></i></div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Mini Map -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-map-marked-alt text-primary me-2"></i>Mini Map Preview</h6>
            </div>
            <div class="card-body p-4">
                <div id="map" style="height: 350px; z-index: 1;"></div>
            </div>
        </div>
    </div>
    <!-- Chart -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-chart-pie text-primary me-2"></i>Statistik Sebaran Sekolah</h6>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <div style="width: 100%; max-width: 300px;">
                    <canvas id="chartSebaran"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ROW 4: LOGS & GUIDES -->
<div class="row g-4">
    <!-- Daftar Sekolah -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-list-ul text-primary me-2"></i>Daftar Sekolah Terdaftar</h6>
                <a href="<?= base_url('admin/sekolah') ?>" class="btn btn-xs btn-primary rounded-pill px-3">Kelola Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                    <table class="table table-custom align-middle mb-0">
                        <thead class="sticky-top bg-white">
                            <tr>
                                <th class="ps-4">Nama Sekolah</th>
                                <th>Jenjang</th>
                                <th class="pe-4">Alamat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sekolah_list)) : ?>
                                <?php foreach (array_slice($sekolah_list, 0, 10) as $sk) : ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="small text-dark fw-bold"><?= $sk['nama_sekolah'] ?></span>
                                        </td>
                                        <td>
                                            <span class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill small" style="font-size: 0.7rem;">
                                                <?= $sk['jenjang'] ?>
                                            </span>
                                        </td>
                                        <td class="pe-4 text-muted small text-truncate" style="max-width: 200px;">
                                            <?= $sk['alamat'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted small">Belum ada data sekolah.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Tooltip / Guide -->
    <div class="col-lg-5">
        <div class="alert alert-primary border-0 shadow-sm h-100 mb-0 alert-dismissible fade show" role="alert" style="border-radius: 12px; background-color: #eff6ff;">
            <div class="d-flex gap-3 pt-2">
                <div class="fs-2 text-primary opacity-50">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
                <div>
                    <h6 class="fw-bold text-primary">Petunjuk Operasional</h6>
                    <p class="small text-slate-600 mb-2">Panel ini telah terintegrasi dengan <strong>Leaflet.js</strong> untuk pemetaan spasial dan <strong>Chart.js</strong> untuk analisis data.</p>
                    <ul class="small text-slate-600 ps-3 mb-0">
                        <li>Gunakan menu sidebar untuk mengelola data.</li>
                        <li>Update koordinat secara rutin.</li>
                        <li>Pastikan gambar sekolah terkompresi.</li>
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- CDN JS for Spasial & Analytics -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Initializing Mini Map
    var map = L.map('map', {
        zoomControl: true,
        scrollWheelZoom: false
    }).setView([-0.4795, 100.6274], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OSM'
    }).addTo(map);

    // Icon definitions
    var redIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    var blueIcon = L.icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-blue.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // Render sekolah markers
    <?php if (!empty($sekolah_list)) : ?>
        <?php foreach ($sekolah_list as $sk) : ?>
            <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])) : ?>
                var icon = '<?= $sk['jenjang'] ?>' === 'SD' ? redIcon : blueIcon;
                L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], { icon: icon })
                 .addTo(map)
                 .bindPopup("<b><?= $sk['nama_sekolah'] ?></b>");
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    // 2. Initializing Chart.js
    var ctx = document.getElementById('chartSebaran').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sekolah Dasar (SD)', 'Sekolah Menengah (SMP)'],
            datasets: [{
                data: [<?= $total_sd ?>, <?= $total_smp ?>],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 25,
                        font: { size: 12, weight: '500' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(30, 41, 59, 0.9)',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 13 },
                    displayColors: false
                }
            },
            cutout: '75%'
        }
    });
</script>
<?= $this->endSection() ?>
