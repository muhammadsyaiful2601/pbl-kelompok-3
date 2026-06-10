<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">
<style>
    #input-map {
        height: 420px;
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
                        <label class="form-label">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control" value="<?= old('nama_sekolah') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenjang</label>
                        <select name="jenjang" id="jenjangSelect" class="form-select">
                            <option value="SD" <?= old('jenjang') == 'SD' ? 'selected' : '' ?>>SD</option>
                            <option value="SMP" <?= old('jenjang') == 'SMP' ? 'selected' : '' ?>>SMP</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto (opsional)</label>
                        <input type="file" name="foto" id="fotoInput" class="form-control" accept="image/*">
                        <img id="fotoPreview" class="img-preview" src="#" alt="" style="display:none;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control"><?= old('alamat') ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Siswa</label>
                        <input type="number" name="jumlah_siswa" class="form-control" value="<?= old('jumlah_siswa') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"><?= old('deskripsi') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="latitude" id="latitudeInput" class="form-control" readonly value="<?= old('latitude') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="longitude" id="longitudeInput" class="form-control" readonly value="<?= old('longitude') ?>">
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
    document.addEventListener('DOMContentLoaded', function() {
        var defaultLatLng = [-0.941, 100.370];
        var map = L.map('input-map').setView(defaultLatLng, 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var currentMarker = null;

        function placeMarker(latlng) {
            var jenjang = document.getElementById('jenjangSelect').value || 'SD';
            var color = jenjang.toLowerCase() === 'sd' ? '#ff3b30' : '#1e90ff';
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

        // If old values exist, place marker
        var oldLat = document.getElementById('latitudeInput').value;
        var oldLng = document.getElementById('longitudeInput').value;
        if (oldLat && oldLng) {
            placeMarker(L.latLng(parseFloat(oldLat), parseFloat(oldLng)));
            map.setView([parseFloat(oldLat), parseFloat(oldLng)], 15);
        }

        // Foto preview
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