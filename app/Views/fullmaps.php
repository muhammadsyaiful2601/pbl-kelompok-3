<?= $this->extend('layout/template_publik') ?>

<?= $this->section('styles') ?>
<style>
    /* Mengatur tinggi peta agar memenuhi sisa layar */
    .full-map-container {
        height: calc(100vh - 150px);
        min-height: 500px;
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(0, 0, 0, 0.05);
        background-color: #e5e7eb;
        z-index: 1;
    }

    .map-header {
        background: #ffffff;
        padding: 15px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    /* Kustomisasi Popup Leaflet agar lebih rapi */
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .leaflet-popup-content {
        margin: 15px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-3 px-lg-4">

    <div class="map-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h3 class="fw-bold text-slate-800 mb-1">
                <i class="fa-solid fa-map-location-dot text-primary me-2"></i>Peta Interaktif Penuh
            </h3>
            <p class="text-muted mb-0 small">Eksplorasi sebaran sekolah SD dan SMP dengan mode layar penuh.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= base_url('/') ?>" class="btn btn-light border shadow-sm fw-medium px-4 py-2">
                <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    <div id="full-map" class="full-map-container"></div>

</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi peta mode penuh
        var map = L.map('full-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-0.941, 100.370], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Ambil data dinamis dari Controller PHP
        var dataSekolah = <?= json_encode($sekolah ?? []) ?>;

        // Looping untuk menampilkan marker
        dataSekolah.forEach(function(school) {
            // Sesuaikan properti ini jika penamaan field di database Anda berbeda
            var latitude = school.latitude || school.lat;
            var longitude = school.longitude || school.lng;
            var namaSekolah = school.nama_sekolah || school.name;
            var alamatSekolah = school.alamat || school.addr;
            var jenjangSekolah = school.jenjang || school.type || 'SD';
            var statusSekolah = school.status || 'Negeri';
            var jumlahSiswa = school.jumlah_siswa || school.students || 0;

            if (latitude && longitude) {
                var marker = L.marker([latitude, longitude]).addTo(map);

                var badgeColor = jenjangSekolah.toLowerCase() === 'sd' ? 'bg-success' : 'bg-primary';

                var popupContent = `
                    <div style="min-width: 200px;">
                        <div class="mb-2">
                            <span class="badge ${badgeColor} fw-bold" style="font-size:0.7rem;">
                                ${jenjangSekolah.toUpperCase()} ${statusSekolah.toUpperCase()}
                            </span>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">${namaSekolah}</h6>
                        <p class="text-muted small mb-2" style="font-size:0.8rem; line-height: 1.3;">
                            <i class="fa-solid fa-map-marker-alt text-danger me-1"></i> ${alamatSekolah}
                        </p>
                        <div class="border-top pt-2 mt-2 d-flex justify-content-between align-items-center">
                            <span class="text-muted" style="font-size:0.75rem;">
                                <i class="fa-solid fa-users text-primary me-1"></i> ${jumlahSiswa} Siswa
                            </span>
                            <a href="#" class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;">Detail</a>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
            }
        });

        // Menghindari bug ubin peta tidak ter-render sempurna
        setTimeout(function() {
            map.invalidateSize();
        }, 400);
    });
</script>
<?= $this->endSection() ?>