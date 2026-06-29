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
                        <button class="btn btn-primary" type="submit">Simpan Data Sekolah</button>
                    </div>
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
        var defaultLatLng = [-0.4610, 100.6320];
        var map = L.map('input-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView(defaultLatLng, 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Render GeoJSON Layers (Wilayah)
        var geojsonLayers = {};
        var geojsonConfig = {};
        <?php if (!empty($active_geojson)) : ?>
            <?php foreach ($active_geojson as $gj) : ?>
                fetch('<?= base_url($gj['file_geojson']) ?>')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Gagal mengambil file berkas GeoJSON.");
                        }
                        return response.json();
                    })
                    .then(data => {
                        var layer = L.geoJSON(data, {
                                interactive: false,
                                style: {
                                    weight: 2,
                                    color: '<?= $gj['warna_geojson'] ?>',
                                    opacity: 0.8,
                                    fillOpacity: <?= $gj['opacity_geojson'] ?>,
                                    fillColor: "<?= $gj['warna_geojson'] ?>"
                                }
                            })
                            .addTo(map);

                        geojsonLayers[<?= $gj['id_geojson'] ?>] = layer;
                        geojsonConfig[<?= $gj['id_geojson'] ?>] = {
                            color: '<?= $gj['warna_geojson'] ?>',
                            opacity: <?= $gj['opacity_geojson'] ?>
                        };
                    })
                    .catch(err => console.error("Error memuat GeoJSON Leaflet: ", err));
            <?php endforeach; ?>
        <?php endif; ?>

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
    });
</script>
<?= $this->endSection() ?>