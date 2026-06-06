<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-left: 5px solid #3b82f6 !important; reset-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="fw-bold text-dark mb-1" style="letter-spacing: -0.3px;">
                        Selamat Datang Kembali, <span class="text-primary"><?= session()->get('nama_lengkap') ?></span>!
                    </h5>
                    <p class="text-muted small mb-0">Anda masuk sebagai pengendali utama sistem kendali spasial sebaran sekolah.</p>
                </div>
                <div class="d-none d-md-block fs-3 text-primary opacity-50">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm text-white h-100 position-relative overflow-hidden modern-stat-card"
            style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between" style="position: relative; z-index: 2;">
                <div>
                    <h6 class="text-white-50 small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Total Sekolah</h6>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.25rem; font-weight: 800;"><?= $total_sekolah ?></h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-school"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm text-white h-100 position-relative overflow-hidden modern-stat-card"
            style="background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between" style="position: relative; z-index: 2;">
                <div>
                    <h6 class="text-white-50 small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Jenjang SD</h6>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.25rem; font-weight: 800;"><?= $total_sd ?></h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-children"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="card border-0 shadow-sm text-white h-100 position-relative overflow-hidden modern-stat-card"
            style="background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between" style="position: relative; z-index: 2;">
                <div>
                    <h6 class="text-white-50 small text-uppercase fw-bold mb-2" style="letter-spacing: 0.5px;">Jenjang SMP</h6>
                    <h2 class="fw-extrabold mb-0" style="font-size: 2.25rem; font-weight: 800;"><?= $total_smp ?></h2>
                </div>
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-circle-info text-primary me-2"></i>Petunjuk Operasional Panel
                </h6>
            </div>
            <div class="card-body px-4 pb-4 pt-2">
                <p class="text-muted small mb-0" style="line-height: 1.6;">
                    Gunakan menu <strong class="text-dark">Data Sekolah</strong> pada bagian bilah samping (sidebar) untuk melakukan penambahan koordinat baru, pembaruan informasi spasial, atau penghapusan data jika sekolah sudah tidak aktif lagi agar peta publik tetap menyajikan visualisasi yang akurat.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling tambahan untuk memuluskan tampilan ikon dan efek hover */
    .modern-stat-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease !important;
    }

    .modern-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .stat-icon-wrapper {
        font-size: 3.5rem !important;
        position: absolute;
        right: 15px;
        bottom: 5px;
        opacity: 0.2;
        transition: transform 0.3s ease;
    }

    .modern-stat-card:hover .stat-icon-wrapper {
        transform: scale(1.1) rotate(-5deg);
        opacity: 0.3;
    }
</style>
<?= $this->endSection() ?>