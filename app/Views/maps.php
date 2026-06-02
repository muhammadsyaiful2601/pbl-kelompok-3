<?= $this->extend('layout/template_publik') ?>

<?= $this->section('styles') ?>
<style>
    /* Styling khusus agar Card Sekolah terlihat premium */
    .school-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
    }

    .school-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
    }

    .badge-jenjang {
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        z-index: 10;
    }

    .school-img {
        height: 180px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Kustomisasi Landing Page & Tata Letak */
    .hero-section {
        padding: 40px 0 60px 0;
        background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 60%);
    }

    .stat-card {
        border: none;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.08);
    }

    #preview-map {
        height: 400px;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #e5e7eb;
    }

    .scroll-margin {
        scroll-margin-top: 100px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-2">

    <section class="hero-section row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-3">
                <i class="fa-solid fa-map-location-dot me-1"></i> Sistem Informasi Geografis
            </span>
            <h1 class="display-5 fw-bold text-slate-800 mb-3" style="letter-spacing: -1px; line-height: 1.2;">
                Pemetaan Digital Sekolah <br><span class="text-primary">Jenjang SD & SMP</span>
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
        <div class="col-lg-6 text-center">
            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=1000&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" alt="Peta Pendidikan" style="max-height: 380px; width: 100%; object-fit: cover;">
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
                    <h3 class="fw-bold mb-1">142</h3>
                    <p class="text-muted small mb-0 fw-medium">Total Sekolah</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-success-subtle text-success rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-children fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">98</h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Dasar (SD)</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-warning-subtle text-warning rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-graduation-cap fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">44</h3>
                    <p class="text-muted small mb-0 fw-medium">Sekolah Menengah (SMP)</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4">
                    <div class="p-3 bg-info-subtle text-info rounded-circle d-inline-block mb-3" style="width: 60px; height: 60px; line-height: 30px;">
                        <i class="fa-solid fa-user-chalkboard fs-4"></i>
                    </div>
                    <h3 class="fw-bold mb-1">1.820</h3>
                    <p class="text-muted small mb-0 fw-medium">Total Guru & Staff</p>
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
                        <span>Klasterisasi marker otomatis (SD dan SMP)</span>
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

    <hr class="my-5 opacity-25">

    <section class="mb-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">Daftar Lembaga Sekolah</h3>
                <p class="text-muted mb-0 small">Menampilkan cuplikan data sekolah aktif jenjang pendidikan dasar</p>
            </div>

            <div class="btn-group shadow-sm p-1 bg-white rounded-3 border" role="group">
                <button type="button" class="btn btn-sm btn-light active rounded-2 px-3 py-2 fw-semibold" onclick="filterSekolah('semua')">Semua</button>
                <button type="button" class="btn btn-sm btn-light rounded-2 px-3 py-2 fw-semibold" onclick="filterSekolah('SD')">SD</button>
                <button type="button" class="btn btn-sm btn-light rounded-2 px-3 py-2 fw-semibold" onclick="filterSekolah('SMP')">SMP</button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4 item-sekolah" data-jenjang="SD">
                <div class="card school-card shadow-sm h-100 position-relative bg-white">
                    <span class="badge bg-success badge-jenjang">SD NEGERI</span>
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=500" class="card-img-top school-img" alt="SDN 01">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-dark">SDN 01 Kota Utama</h5>
                        <p class="card-text text-muted small flex-grow-1"><i class="fa-solid fa-map-marker-alt me-2 text-danger"></i>Jl. Pendidikan No. 45, Kecamatan Pusat</p>
                        <div class="border-top pt-3 mt-2 d-flex justify-content-between text-muted small fw-medium">
                            <span><i class="fa-solid fa-users me-1 text-primary"></i> 320 Siswa</span>
                            <span>Akreditasi <strong class="text-success">A</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 item-sekolah" data-jenjang="SMP">
                <div class="card school-card shadow-sm h-100 position-relative bg-white">
                    <span class="badge bg-primary badge-jenjang">SMP NEGERI</span>
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=500" class="card-img-top school-img" alt="SMPN 03">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-dark">SMP Negeri 3 Unggulan</h5>
                        <p class="card-text text-muted small flex-grow-1"><i class="fa-solid fa-map-marker-alt me-2 text-danger"></i>Jl. Merdeka Barat No. 12, Wilayah Utara</p>
                        <div class="border-top pt-3 mt-2 d-flex justify-content-between text-muted small fw-medium">
                            <span><i class="fa-solid fa-users me-1 text-primary"></i> 512 Siswa</span>
                            <span>Akreditasi <strong class="text-success">A</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 item-sekolah" data-jenjang="SD">
                <div class="card school-card shadow-sm h-100 position-relative bg-white">
                    <span class="badge bg-success badge-jenjang">SD NEGERI</span>
                    <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?q=80&w=500" class="card-img-top school-img" alt="SDN 05">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2 text-dark">SDN 05 Merdeka Sejahtera</h5>
                        <p class="card-text text-muted small flex-grow-1"><i class="fa-solid fa-map-marker-alt me-2 text-danger"></i>Jl. Jenderal Sudirman Km. 3, Sektor Timur</p>
                        <div class="border-top pt-3 mt-2 d-flex justify-content-between text-muted small fw-medium">
                            <span><i class="fa-solid fa-users me-1 text-primary"></i> 180 Siswa</span>
                            <span>Akreditasi <strong class="text-warning">B</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Fungsi untuk memfilter Card
    function filterSekolah(jenjang) {
        const items = document.querySelectorAll('.item-sekolah');
        const buttons = document.querySelectorAll('.btn-group .btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        if (event && event.target) {
            event.target.classList.add('active');
        }

        items.forEach(item => {
            if (jenjang === 'semua') {
                item.style.display = 'block';
            } else {
                if (item.getAttribute('data-jenjang').toLowerCase() === jenjang.toLowerCase()) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Atur koordinat default (Ganti dengan koordinat wilayah pusat Dinas Pendidikan Anda)
        var map = L.map('preview-map').setView([-0.941, 100.370], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menerima data dinamis dari Controller PHP
        var dataSekolah = <?= json_encode($sekolah ?? []) ?>;

        // Looping data marker otomatis dari database
        dataSekolah.forEach(function(school) {
            // Sesuaikan properti ini jika penamaan field di database Anda berbeda
            var latitude = school.latitude || school.lat;
            var longitude = school.longitude || school.lng;
            var namaSekolah = school.nama_sekolah || school.name;
            var alamatSekolah = school.alamat || school.addr;
            var jenjangSekolah = school.jenjang || school.type || 'SD';

            if (latitude && longitude) {
                var marker = L.marker([latitude, longitude]).addTo(map);

                var badgeColor = jenjangSekolah.toLowerCase() === 'sd' ? 'bg-success' : 'bg-primary';

                marker.bindPopup(`
                    <div style="min-width: 160px;">
                        <span class="badge ${badgeColor} mb-1">${jenjangSekolah.toUpperCase()}</span>
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">${namaSekolah}</h6>
                        <p class="text-muted small mb-0" style="font-size: 0.8rem;">
                            <i class="fa-solid fa-map-marker-alt text-danger me-1"></i> ${alamatSekolah}
                        </p>
                    </div>
                `);
            }
        });

        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    });
</script>
<?= $this->endSection() ?>