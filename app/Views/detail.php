<?= $this->extend('layout/template_publik') ?>

<?= $this->section('styles') ?>
<style>
    .detail-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        background: white;
    }

    .detail-header-img {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .info-item {
        margin-bottom: 25px;
    }

    .info-label {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 5px;
        display: block;
    }

    .info-value {
        font-size: 1.1rem;
        color: #1e293b;
        font-weight: 500;
    }

    #detail-map {
        height: 350px;
        border-radius: 12px;
        margin-top: 20px;
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

    .stats-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 15px;
        border-radius: 50px;
        background: #f1f5f9;
        font-weight: 600;
        font-size: 0.9rem;
        color: #475569;
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
        <div class="col-lg-8">
            <div class="detail-card mb-4">
                <img src="<?= $sekolah['foto'] ? base_url('uploads/sekolah/' . $sekolah['foto']) : 'https://via.placeholder.com/800x400?text=No+Photo' ?>" class="detail-header-img" alt="<?= $sekolah['nama_sekolah'] ?>">
                <div class="p-4 p-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge <?= $sekolah['jenjang'] == 'SD' ? 'bg-danger' : 'bg-primary' ?> px-3 py-2 rounded-pill">
                            <?= $sekolah['jenjang'] ?>
                        </span>
                        <div class="stats-badge">
                            <i class="fa-solid fa-users me-2 text-primary"></i>
                            <?= number_format($sekolah['jumlah_siswa'], 0, ',', '.') ?> Siswa
                        </div>
                    </div>

                    <h1 class="display-6 fw-bold text-slate-800 mb-4"><?= $sekolah['nama_sekolah'] ?></h1>

                    <div class="row">
                        <div class="col-md-6 info-item">
                            <span class="info-label">Alamat Lengkap</span>
                            <div class="info-value">
                                <i class="fa-solid fa-location-dot text-danger me-2"></i>
                                <?= $sekolah['alamat'] ?>
                            </div>
                        </div>
                        <div class="col-md-6 info-item">
                            <span class="info-label">Koordinat Lokasi</span>
                            <div class="info-value">
                                <i class="fa-solid fa-map-pin text-primary me-2"></i>
                                <?= $sekolah['latitude'] ?>, <?= $sekolah['longitude'] ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="info-item">
                        <span class="info-label">Deskripsi Sekolah</span>
                        <div class="info-value text-muted" style="line-height: 1.8; font-size: 1rem;">
                            <?= $sekolah['deskripsi_sekolah'] ?: 'Tidak ada deskripsi tersedia untuk sekolah ini.' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="detail-card p-4">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-map-location-dot me-2 text-primary"></i>Lokasi Geografis</h5>
                <p class="text-muted small">Titik koordinat presisi sekolah dalam sistem pemetaan digital.</p>
                <div id="detail-map"></div>
                <div class="mt-4">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?= $sekolah['latitude'] ?>,<?= $sekolah['longitude'] ?>" target="_blank" class="btn btn-outline-primary w-100 rounded-pill fw-semibold">
                        <i class="fa-solid fa-directions me-2"></i>Petunjuk Arah (Google Maps)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Inisialisasi Peta Detail
    var lat = <?= $sekolah['latitude'] ?>;
    var lng = <?= $sekolah['longitude'] ?>;
    var zoom = 15;

    var map = L.map('detail-map').setView([lat, lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

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

    var iconSekolah = <?= $sekolah['jenjang'] == 'SD' ? 'redIcon' : 'blueIcon' ?>;

    L.marker([lat, lng], {
        icon: iconSekolah
    }).addTo(map)
    .bindPopup('<b><?= $sekolah['nama_sekolah'] ?></b>').openPopup();
</script>
<?= $this->endSection() ?>
