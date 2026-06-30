<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">
<style>
    #input-map {
        height: 420px;
        border-radius: 8px;
    }

    .img-preview {
        max-width: 200px;
        max-height: 150px;
        object-fit: cover;
        display: block;
        margin-top: 10px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/input-data/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div id="input-map"></div>
                    <p class="small text-muted mt-2">Klik pada peta untuk menempatkan marker lokasi sekolah. Pilih jenjang untuk mengubah warna marker.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Sekolah *</label>
                        <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan nama sekolah lengkap" value="<?= old('nama_sekolah') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Kepala Sekolah</label>
                        <input type="text" name="kepala_sekolah" class="form-control" placeholder="Masukkan nama kepala sekolah" value="<?= old('kepala_sekolah') ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenjang *</label>
                            <select name="jenjang" id="jenjangSelect" class="form-select">
                                <option value="">Pilih Jenjang</option>
                                <option value="SD" <?= old('jenjang') == 'SD' ? 'selected' : '' ?>>SD</option>
                                <option value="SMP" <?= old('jenjang') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                                <option value="TK" <?= old('jenjang') == 'TK' ? 'selected' : '' ?>>TK</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori *</label>
                            <select name="kategori" class="form-select">
                                <option value="">Pilih Kategori</option>
                                <option value="Negeri" <?= old('kategori') == 'Negeri' ? 'selected' : '' ?>>Negeri</option>
                                <option value="Swasta" <?= old('kategori') == 'Swasta' ? 'selected' : '' ?>>Swasta</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Siswa</label>
                        <input type="number" name="jumlah_siswa" class="form-control" value="<?= old('jumlah_siswa', 0) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Website Sekolah</label>
                        <input type="text" name="website" class="form-control" placeholder="https://contohsekolah.sch.id" value="<?= old('website') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Akreditasi *</label>
                        <select name="akreditasi" class="form-select">
                            <option value="">Pilih Akreditasi...</option>
                            <option value="A" <?= old('akreditasi') == 'A' ? 'selected' : '' ?>>A</option>
                            <option value="B" <?= old('akreditasi') == 'B' ? 'selected' : '' ?>>B</option>
                            <option value="C" <?= old('akreditasi') == 'C' ? 'selected' : '' ?>>C</option>
                            <option value="Belum Terakreditasi" <?= old('akreditasi') == 'Belum Terakreditasi' ? 'selected' : '' ?>>Belum Terakreditasi</option>
                            <option value="Tidak Diketahui" <?= old('akreditasi') == 'Tidak Diketahui' ? 'selected' : '' ?>>Tidak Diketahui</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Sekolah (opsional)</label>
                        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                        <img id="fotoPreview" class="img-preview" src="#" alt="" style="display:none;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat *</label>
                        <textarea name="alamat" class="form-control" placeholder="Alamat lengkap sekolah..."><?= old('alamat') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Sekolah</label>
                        <textarea name="deskripsi_sekolah" class="form-control" placeholder="Tuliskan profil singkat atau deskripsi sekolah..."><?= old('deskripsi_sekolah') ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" name="latitude" id="latitudeInput" class="form-control" readonly placeholder="Latitude" value="<?= old('latitude') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" name="longitude" id="longitudeInput" class="form-control" readonly placeholder="Longitude" value="<?= old('longitude') ?>">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit" id="btnSimpan">Simpan Data Sekolah</button>
                    </div>
                    <div id="form-warning-container"></div>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    /* global FileReader, L */
    document.addEventListener('DOMContentLoaded', function() {
        var defaultLatLng = [-0.5278869336553939, 100.76173868221711];
        var map = L.map('input-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView(defaultLatLng, 11);

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

        // ===== VALIDASI WILAYAH =====
        // Fungsi mengecek apakah titik berada di dalam layer GeoJSON (Polygon)
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

        // Cek apakah titik berada di dalam salah satu wilayah yang diizinkan
        function isInsideAllowedRegion(latlng) {
            // Jika tidak ada layer GeoJSON sama sekali, izinkan semua lokasi
            if (Object.keys(geojsonLayers).length === 0) return true;

            var insideAny = false;
            Object.keys(geojsonLayers).forEach(function(gjId) {
                var isVisible = localStorage.getItem('geojson_vis_' + gjId);
                // Hanya cek layer yang sedang aktif/tampak
                if (isVisible === null || isVisible === 'true') {
                    if (isLatLngInLayer(latlng, geojsonLayers[gjId])) {
                        insideAny = true;
                    }
                }
            });
            return insideAny;
        }

        // Hapus pesan peringatan jika ada
        function removeWarning() {
            var existingWarning = document.getElementById('region-warning');
            if (existingWarning) {
                existingWarning.remove();
            }
        }

        // Tampilkan pesan peringatan
        function showWarning(message) {
            removeWarning();
            var warningDiv = document.createElement('div');
            warningDiv.id = 'region-warning';
            warningDiv.className = 'alert alert-warning alert-dismissible fade show mt-2';
            warningDiv.setAttribute('role', 'alert');
            warningDiv.innerHTML = `
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <strong>Peringatan!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            // Sisipkan setelah peta
            var mapContainer = document.getElementById('input-map');
            mapContainer.parentNode.insertBefore(warningDiv, mapContainer.nextSibling);
        }

        var currentMarker = null;

        function placeMarker(latlng) {
            var jenjang = document.getElementById('jenjangSelect').value || 'SD';
            var color = jenjang.toLowerCase() === 'sd' ?
                '#ff3b30' :
                jenjang.toLowerCase() === 'smp' ?
                '#1e90ff' :
                '#38bdf8';
            if (currentMarker) {
                map.removeLayer(currentMarker);
            }
            currentMarker = L.circleMarker(latlng, {
                radius: 8,
                color: color,
                fillColor: color,
                fillOpacity: 0.9
            }).addTo(map);
            document.getElementById('latitudeInput').value = latlng.lat.toFixed(7);
            document.getElementById('longitudeInput').value = latlng.lng.toFixed(7);
        }

        map.on('click', function(e) {
            removeWarning();

            // Validasi: cek apakah titik berada di dalam wilayah yang diizinkan
            if (!isInsideAllowedRegion(e.latlng)) {
                showWarning('Lokasi yang Anda pilih berada di luar wilayah yang diizinkan. Silakan pilih lokasi di dalam wilayah yang telah ditentukan.');
                return;
            }

            placeMarker(e.latlng);
        });

        document.getElementById('jenjangSelect').addEventListener('change', function() {
            if (currentMarker) {
                var latlng = currentMarker.getLatLng();
                placeMarker(latlng);
            }
        });

        var oldLat = document.getElementById('latitudeInput').value;
        var oldLng = document.getElementById('longitudeInput').value;
        if (oldLat && oldLng) {
            placeMarker(L.latLng(parseFloat(oldLat), parseFloat(oldLng)));
            map.setView([parseFloat(oldLat), parseFloat(oldLng)], 14);
        }

        // Preview Foto upload
        var fotoInput = document.getElementById('fotoInput');
        fotoInput.addEventListener('change', function(e) {
            var file = this.files && this.files[0];
            var preview = document.getElementById('fotoPreview');
            if (file) {
                var reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // ===== VALIDASI FORM SEBELUM SUBMIT (INLINE) =====
        // Hapus semua class is-invalid dan pesan error dari field
        function resetInlineValidation() {
            document.querySelectorAll('.is-invalid').forEach(function(el) {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback-field').forEach(function(el) {
                el.remove();
            });
        }

        // Tambah class is-invalid dan teks error di bawah field
        function markInvalid(field, message) {
            field.classList.add('is-invalid');
            // Cari parent wrapper .mb-3 lalu tambah div error
            var parent = field.closest('.mb-3') || field.parentElement;
            var feedback = document.createElement('div');
            feedback.className = 'invalid-feedback invalid-feedback-field';
            feedback.textContent = message;
            parent.appendChild(feedback);
        }

        // Validasi form saat submit
        document.querySelector('form').addEventListener('submit', function(e) {
            resetInlineValidation();
            var hasError = false;

            var namaField = this.querySelector('[name="nama_sekolah"]');
            var jenjangField = document.getElementById('jenjangSelect');
            var kategoriField = this.querySelector('[name="kategori"]');
            var akreditasiField = this.querySelector('[name="akreditasi"]');
            var alamatField = this.querySelector('[name="alamat"]');
            var latField = document.getElementById('latitudeInput');
            var lngField = document.getElementById('longitudeInput');

            if (!namaField.value.trim()) {
                markInvalid(namaField, 'Nama Sekolah wajib diisi.');
                hasError = true;
            }
            if (!jenjangField.value) {
                markInvalid(jenjangField, 'Jenjang wajib dipilih.');
                hasError = true;
            }
            if (!kategoriField.value) {
                markInvalid(kategoriField, 'Kategori wajib dipilih.');
                hasError = true;
            }
            if (!akreditasiField.value) {
                markInvalid(akreditasiField, 'Akreditasi wajib dipilih.');
                hasError = true;
            }
            if (!alamatField.value.trim()) {
                markInvalid(alamatField, 'Alamat wajib diisi.');
                hasError = true;
            }
            if (!latField.value.trim() || !lngField.value.trim()) {
                markInvalid(latField, 'Lokasi sekolah (koordinat) belum dipilih. Klik pada peta.');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                // Scroll ke field error pertama
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
    });
</script>
<?= $this->endSection() ?>