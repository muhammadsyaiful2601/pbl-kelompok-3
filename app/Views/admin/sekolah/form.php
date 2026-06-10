<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<style>
    #map-input {
        height: 350px;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php $validation = \Config\Services::validation(); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid <?= isset($sekolah) ? 'fa-pen-to-square' : 'fa-plus' ?> text-primary me-2"></i>
                    <?= isset($sekolah) ? 'Edit Data Sekolah' : 'Tambah Sekolah Baru' ?>
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('admin/sekolah/simpan') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_sekolah" value="<?= $sekolah['id_sekolah'] ?? '' ?>">
                    <input type="hidden" name="foto_lama" value="<?= $sekolah['foto'] ?? '' ?>">

                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" name="nama_sekolah" class="form-control <?= ($validation->hasError('nama_sekolah')) ? 'is-invalid' : '' ?>" value="<?= old('nama_sekolah', $sekolah['nama_sekolah'] ?? '') ?>" placeholder="Masukkan nama sekolah lengkap">
                                <div class="invalid-feedback"><?= $validation->getError('nama_sekolah') ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jenjang <span class="text-danger">*</span></label>
                                    <select name="jenjang" class="form-select <?= ($validation->hasError('jenjang')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Jenjang...</option>
                                        <option value="SD" <?= old('jenjang', $sekolah['jenjang'] ?? '') == 'SD' ? 'selected' : '' ?>>Sekolah Dasar (SD)</option>
                                        <option value="SMP" <?= old('jenjang', $sekolah['jenjang'] ?? '') == 'SMP' ? 'selected' : '' ?>>Sekolah Menengah Pertama (SMP)</option>
                                    </select>
                                    <div class="invalid-feedback"><?= $validation->getError('jenjang') ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jumlah Siswa</label>
                                    <input type="number" name="jumlah_siswa" class="form-control" value="<?= old('jumlah_siswa', $sekolah['jumlah_siswa'] ?? '') ?>" placeholder="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Website Sekolah</label>
                                <input type="text" name="website" class="form-control <?= ($validation->hasError('website')) ? 'is-invalid' : '' ?>" value="<?= old('website', $sekolah['website'] ?? '') ?>" placeholder="https://contohsekolah.sch.id">
                                <div class="invalid-feedback"><?= $validation->getError('website') ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : '' ?>" rows="3" placeholder="Alamat lengkap sekolah..."><?= old('alamat', $sekolah['alamat'] ?? '') ?></textarea>
                                <div class="invalid-feedback"><?= $validation->getError('alamat') ?></div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Deskripsi Sekolah</label>
                                <textarea name="deskripsi_sekolah" class="form-control" rows="5" placeholder="Tuliskan profil singkat atau deskripsi sekolah..."><?= old('deskripsi_sekolah', $sekolah['deskripsi_sekolah'] ?? '') ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Pilih Lokasi di Peta <span class="text-danger">*</span></label>
                                <div id="map-input" class="mb-2"></div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="text" name="latitude" id="latitude" class="form-control form-control-sm <?= ($validation->hasError('latitude')) ? 'is-invalid' : '' ?>" value="<?= old('latitude', $sekolah['latitude'] ?? '') ?>" placeholder="Latitude">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="longitude" id="longitude" class="form-control form-control-sm <?= ($validation->hasError('longitude')) ? 'is-invalid' : '' ?>" value="<?= old('longitude', $sekolah['longitude'] ?? '') ?>" placeholder="Longitude">
                                    </div>
                                </div>
                                <div class="text-danger small mt-1"><?= $validation->getError('latitude') ?: $validation->getError('longitude') ?></div>
                                <p class="text-muted small mt-2"><i class="fa-solid fa-circle-info me-1"></i> Klik pada peta atau ketik koordinat (format desimal) untuk menandai lokasi sekolah.</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Foto Sekolah</label>
                                <div class="card border-dashed p-3 text-center bg-light" style="border: 2px dashed #cbd5e1; border-radius: 12px;">
                                    <?php if (isset($sekolah['foto']) && $sekolah['foto']) : ?>
                                        <img src="<?= base_url('uploads/sekolah/' . $sekolah['foto']) ?>" id="preview-foto" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 150px; object-fit: cover;">
                                    <?php else : ?>
                                        <img src="" id="preview-foto" class="img-fluid rounded mb-3 shadow-sm d-none" style="max-height: 150px; object-fit: cover;">
                                        <div id="placeholder-foto">
                                            <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted opacity-50 mb-2"></i>
                                            <p class="small text-muted mb-0">Drag & drop atau klik untuk upload foto</p>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" name="foto" id="foto-input" class="form-control mt-2 <?= ($validation->hasError('foto')) ? 'is-invalid' : '' ?>" onchange="previewImage()">
                                    <div class="invalid-feedback"><?= $validation->getError('foto') ?></div>
                                    <p class="text-muted x-small mt-2 mb-0">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hr-border my-4"></div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('admin/sekolah') ?>" class="btn btn-light px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-save me-2"></i> <?= isset($sekolah) ? 'Simpan Perubahan' : 'Simpan Data' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Inisialisasi Peta untuk Inputan
    var defaultLat = <?= $sekolah['latitude'] ?? -0.4795 ?>;
    var defaultLng = <?= $sekolah['longitude'] ?? 100.6274 ?>;
    var zoomLevel = <?= isset($sekolah['latitude']) ? 16 : 13 ?>;

    var map = L.map('map-input').setView([defaultLat, defaultLng], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker;
    var latInput = document.getElementById('latitude');
    var lngInput = document.getElementById('longitude');

    // Jika sedang edit, tampilkan marker di posisi awal
    <?php if (isset($sekolah['latitude'])) : ?>
        marker = L.marker([defaultLat, defaultLng]).addTo(map);
    <?php endif; ?>

    // Jika input sudah berisi koordinat (mis. ketika redirect withInput), tampilkan marker
    if (latInput && lngInput && latInput.value && lngInput.value) {
        var latVal = parseFloat(latInput.value);
        var lngVal = parseFloat(lngInput.value);
        if (isFinite(latVal) && isFinite(lngVal)) {
            if (marker) {
                marker.setLatLng([latVal, lngVal]);
            } else {
                marker = L.marker([latVal, lngVal]).addTo(map);
            }
            map.setView([latVal, lngVal], zoomLevel);
        }
    }

    // Event Klik Peta
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        // Set input dengan 6 desimal untuk konsistensi
        if (latInput) latInput.value = lat.toFixed(6);
        if (lngInput) lngInput.value = lng.toFixed(6);
    });

    // Update marker saat user mengetik koordinat secara manual
    function updateMarkerFromInputs() {
        if (!latInput || !lngInput) return;
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(lngInput.value);

        if (!isFinite(lat) || !isFinite(lng)) return;
        if (lat < -90 || lat > 90 || lng < -180 || lng > 180) return;

        var latlng = L.latLng(lat, lng);
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng).addTo(map);
        }
        map.panTo(latlng);
    }

    if (latInput && lngInput) {
        latInput.addEventListener('input', updateMarkerFromInputs);
        lngInput.addEventListener('input', updateMarkerFromInputs);
        // Inisialisasi saat load
        updateMarkerFromInputs();
    }

    // Preview Gambar
    function previewImage() {
        const foto = document.querySelector('#foto-input');
        const imgPreview = document.querySelector('#preview-foto');
        const placeholder = document.querySelector('#placeholder-foto');

        imgPreview.classList.remove('d-none');
        if (placeholder) placeholder.classList.add('d-none');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>
<?= $this->endSection() ?>