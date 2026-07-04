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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Kepala Sekolah <small class="text-muted">(opsional)</small></label>
                                <input type="text" name="kepala_sekolah" class="form-control" value="<?= old('kepala_sekolah', $sekolah['kepala_sekolah'] ?? '') ?>" placeholder="Masukkan nama kepala sekolah">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Jenjang <span class="text-danger">*</span></label>
                                    <select name="jenjang" class="form-select <?= ($validation->hasError('jenjang')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Jenjang...</option>
                                        <option value="SD" <?= old('jenjang', $sekolah['jenjang'] ?? '') == 'SD' ? 'selected' : '' ?>>Sekolah Dasar (SD)</option>
                                        <option value="SMP" <?= old('jenjang', $sekolah['jenjang'] ?? '') == 'SMP' ? 'selected' : '' ?>>Sekolah Menengah Pertama (SMP)</option>
                                        <option value="TK" <?= old('jenjang', $sekolah['jenjang'] ?? '') == 'TK' ? 'selected' : '' ?>>Taman Kanak-kanak (TK)</option>
                                    </select>
                                    <div class="invalid-feedback"><?= $validation->getError('jenjang') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-select <?= ($validation->hasError('kategori')) ? 'is-invalid' : '' ?>">
                                        <option value="">Pilih Kategori...</option>
                                        <option value="negri" <?= old('kategori', $sekolah['kategori'] ?? '') == 'negri' ? 'selected' : '' ?>>Negeri (Negri)</option>
                                        <option value="swasta" <?= old('kategori', $sekolah['kategori'] ?? '') == 'swasta' ? 'selected' : '' ?>>Swasta</option>
                                    </select>
                                    <div class="invalid-feedback"><?= $validation->getError('kategori') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-semibold">Kurikulum</label>
                                    <input type="text" name="kurikulum" class="form-control" value="<?= old('kurikulum', $sekolah['kurikulum'] ?? '') ?>" placeholder="Contoh: Kurikulum Merdeka">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Website Sekolah</label>
                                    <input type="text" name="website" class="form-control <?= ($validation->hasError('website')) ? 'is-invalid' : '' ?>" value="<?= old('website', $sekolah['website'] ?? '') ?>" placeholder="https://contohsekolah.sch.id">
                                    <div class="invalid-feedback"><?= $validation->getError('website') ?></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kontak Sekolah <small class="text-muted">(opsional)</small></label>
                                    <input type="text" name="kontak" class="form-control" value="<?= old('kontak', $sekolah['kontak'] ?? '') ?>" placeholder="Telepon / WhatsApp / Email">
                                    <div class="invalid-feedback"><?= $validation->getError('kontak') ?></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tahun Berdiri <small class="text-muted">(opsional)</small></label>
                                <select name="tahun_berdiri" class="form-select">
                                    <option value="">Pilih Tahun...</option>
                                    <?php $selectedTahun = old('tahun_berdiri', $sekolah['tahun_berdiri'] ?? ''); ?>
                                    <?php for ($t = date('Y'); $t >= 1900; $t--): ?>
                                        <option value="<?= $t ?>" <?= $selectedTahun == $t ? 'selected' : '' ?>><?= $t ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Akreditasi <span class="text-danger">*</span></label>
                                <select name="akreditasi" class="form-select <?= ($validation->hasError('akreditasi')) ? 'is-invalid' : '' ?>">
                                    <option value="">Pilih Akreditasi...</option>
                                    <option value="A" <?= old('akreditasi', $sekolah['akreditasi'] ?? '') == 'A' ? 'selected' : '' ?>>A</option>
                                    <option value="B" <?= old('akreditasi', $sekolah['akreditasi'] ?? '') == 'B' ? 'selected' : '' ?>>B</option>
                                    <option value="C" <?= old('akreditasi', $sekolah['akreditasi'] ?? '') == 'C' ? 'selected' : '' ?>>C</option>
                                    <option value="Belum Terakreditasi" <?= old('akreditasi', $sekolah['akreditasi'] ?? '') == 'Belum Terakreditasi' ? 'selected' : '' ?>>Belum Terakreditasi</option>
                                    <option value="Tidak Diketahui" <?= old('akreditasi', $sekolah['akreditasi'] ?? '') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                                </select>
                                <div class="invalid-feedback"><?= $validation->getError('akreditasi') ?></div>
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

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Visi <small class="text-muted">(opsional)</small></label>
                                <textarea name="visi" class="form-control" rows="4" placeholder="Tuliskan visi sekolah..."><?= old('visi', $sekolah['visi'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Misi <small class="text-muted">(opsional)</small></label>
                                <textarea name="misi" class="form-control" rows="4" placeholder="Tuliskan misi sekolah..."><?= old('misi', $sekolah['misi'] ?? '') ?></textarea>
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
                    <div id="form-warning-container-form"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Inisialisasi Peta untuk Inputan
    var defaultLat = <?= $sekolah['latitude'] ?? -0.5278869336553939 ?>;
    var defaultLng = <?= $sekolah['longitude'] ?? 100.76173868221711 ?>;
    var zoomLevel = <?= isset($sekolah['latitude']) ? 16 : 11 ?>;

    var map = L.map('map-input').setView([defaultLat, defaultLng], zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Render GeoJSON Layers (Wilayah) - Full Maps Sync
    var geojsonLayers = {};
    var geojsonConfig = {};
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            fetch('<?= base_url($gj['file_geojson']) ?>')
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Gagal mengambil file GeoJSON.");
                    }
                    return response.json();
                })
                .then(data => {
                    var layer = L.geoJSON(data, {
                        interactive: false,
                        style: function(feature) {
                            return {
                                color: "#000000", // Black boundary
                                weight: 2,
                                opacity: 0.8,
                                fillOpacity: <?= $gj['opacity_geojson'] ?>,
                                fillColor: "<?= $gj['warna_geojson'] ?>"
                            };
                        }
                    }).bindPopup("<b>Wilayah:</b> <?= $gj['nama_geojson'] ?>");

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
                })
                .catch(err => console.error("Error memuat GeoJSON: ", err));
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

    // ===== VALIDASI WILAYAH =====
    function isLatLngInLayer(latlng, layer) {
        if (!layer) return false;
        var found = false;
        layer.eachLayer(function(l) {
            if (l instanceof L.Polygon) {
                if (isLatLngInPolygon(latlng, l)) found = true;
            }
        });
        return found;
    }

    function isLatLngInPolygon(latlng, polygon) {
        var lat = latlng.lat,
            lng = latlng.lng;
        var coords = polygon.getLatLngs();

        function checkInside(points) {
            if (points.length > 0 && Array.isArray(points[0]) && !points[0].hasOwnProperty('lat')) {
                for (var i = 0; i < points.length; i++)
                    if (checkInside(points[i])) return true;
                return false;
            }
            var inside = false;
            for (var i = 0, j = points.length - 1; i < points.length; j = i++) {
                var xi = points[i].lat,
                    yi = points[i].lng;
                var xj = points[j].lat,
                    yj = points[j].lng;
                var intersect = ((yi > lng) != (yj > lng)) && (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);
                if (intersect) inside = !inside;
            }
            return inside;
        }
        return checkInside(coords);
    }

    function isInsideAllowedRegion(latlng) {
        if (Object.keys(geojsonLayers).length === 0) return true;

        var insideAny = false;
        Object.keys(geojsonLayers).forEach(function(gjId) {
            var isVisible = localStorage.getItem('geojson_vis_' + gjId);
            if (isVisible === null || isVisible === 'true') {
                if (isLatLngInLayer(latlng, geojsonLayers[gjId])) {
                    insideAny = true;
                }
            }
        });
        return insideAny;
    }

    function removeWarningForm() {
        var existingWarning = document.getElementById('region-warning-form');
        if (existingWarning) {
            existingWarning.remove();
        }
    }

    function showWarningForm(message) {
        removeWarningForm();
        var warningDiv = document.createElement('div');
        warningDiv.id = 'region-warning-form';
        warningDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
        warningDiv.setAttribute('role', 'alert');
        warningDiv.innerHTML = `
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <strong>Peringatan!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        var mapContainer = document.getElementById('map-input');
        mapContainer.parentNode.insertBefore(warningDiv, mapContainer.nextSibling);
    }

    // Event Klik Peta
    map.on('click', function(e) {
        removeWarningForm();

        // Validasi: cek apakah titik berada di dalam wilayah yang diizinkan
        if (!isInsideAllowedRegion(e.latlng)) {
            showWarningForm('Lokasi yang Anda pilih berada di luar wilayah yang diizinkan. Silakan pilih lokasi di dalam wilayah yang telah ditentukan.');
            return;
        }

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

    // ===== VALIDASI FORM SEBELUM SUBMIT (INLINE) =====
    function resetInlineValidationForm() {
        document.querySelectorAll('.is-invalid').forEach(function(el) {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback-field').forEach(function(el) {
            el.remove();
        });
    }

    function markInvalidForm(field, message) {
        field.classList.add('is-invalid');
        var parent = field.closest('.mb-3') || field.parentElement;
        var feedback = document.createElement('div');
        feedback.className = 'invalid-feedback invalid-feedback-field';
        feedback.textContent = message;
        parent.appendChild(feedback);
    }

    // Validasi form saat submit
    document.querySelector('form').addEventListener('submit', function(e) {
        resetInlineValidationForm();
        var hasError = false;

        var namaField = this.querySelector('[name="nama_sekolah"]');
        var jenjangField = this.querySelector('[name="jenjang"]');
        var kategoriField = this.querySelector('[name="kategori"]');
        var akreditasiField = this.querySelector('[name="akreditasi"]');
        var alamatField = this.querySelector('[name="alamat"]');
        var latField = document.getElementById('latitude');
        var lngField = document.getElementById('longitude');

        if (!namaField.value.trim()) {
            markInvalidForm(namaField, 'Nama Sekolah wajib diisi.');
            hasError = true;
        }
        if (!jenjangField.value) {
            markInvalidForm(jenjangField, 'Jenjang wajib dipilih.');
            hasError = true;
        }
        if (!kategoriField.value) {
            markInvalidForm(kategoriField, 'Kategori wajib dipilih.');
            hasError = true;
        }
        if (!akreditasiField.value) {
            markInvalidForm(akreditasiField, 'Akreditasi wajib dipilih.');
            hasError = true;
        }
        if (!alamatField.value.trim()) {
            markInvalidForm(alamatField, 'Alamat wajib diisi.');
            hasError = true;
        }
        if (!latField.value.trim() || !lngField.value.trim()) {
            markInvalidForm(latField, 'Lokasi sekolah (koordinat) belum dipilih. Klik pada peta.');
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
            var firstError = document.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus({
                    preventScroll: true
                });
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        }
    });

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