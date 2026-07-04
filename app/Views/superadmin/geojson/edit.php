<?= $this->extend('layout/template') ?>

<?= $this->section('styles') ?>
<style>
    .preview-map-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #eef2f6;
    }

    .preview-map-wrapper .map-preview-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 999;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #475569;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .geo-card {
        border: none !important;
        border-radius: 16px !important;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 1px 2px rgba(0, 0, 0, 0.04) !important;
    }

    .geo-card .card-header {
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .geo-card .form-control {
        border-color: #e2e8f0;
        border-radius: 10px;
    }

    .geo-card .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .geo-card .btn-primary {
        background: linear-gradient(45deg, #6366f1, #4f46e5);
        border: none;
        border-radius: 20px;
        font-weight: 600;
        padding: 10px 24px;
    }

    .geo-card .btn-light {
        border-radius: 20px;
        font-weight: 600;
        padding: 10px 24px;
        border: 1px solid #e2e8f0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card geo-card mb-4">
            <div class="card-header bg-transparent px-4 pt-4">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-palette text-primary me-2"></i>Konfigurasi Gaya Visual GeoJSON</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                        <ul class="mb-0 small">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('superadmin/geojson/update/' . $geojson['id_geojson']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Layer / Wilayah</label>
                        <input type="text" class="form-control" name="nama_geojson" value="<?= old('nama_geojson', $geojson['nama_geojson']) ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Warna Wilayah</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="color" class="form-control form-control-color border-0 p-0" style="width: 50px; height: 38px;" name="warna_geojson" value="<?= old('warna_geojson', $geojson['warna_geojson']) ?>" title="Pilih warna">
                                <input type="text" class="form-control" value="<?= old('warna_geojson', $geojson['warna_geojson']) ?>" readonly>
                            </div>
                            <small class="text-muted mt-1 d-block">Klik ikon warna di atas untuk memilih warna dari palet.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Opacity (0.1 - 1.0)</label>
                            <input type="range" class="form-range mt-2" name="opacity_geojson" min="0.1" max="1" step="0.1" value="<?= old('opacity_geojson', $geojson['opacity_geojson']) ?>" id="opacityRange">
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <span class="small text-muted">Transparan</span>
                                <span class="badge bg-primary rounded-pill" id="opacityValue"><?= $geojson['opacity_geojson'] ?></span>
                                <span class="small text-muted">Solid</span>
                            </div>
                        </div>
                    </div>

                    <div class="card geo-card mb-4">
                        <div class="card-header bg-transparent px-4 pt-3 pb-0 d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                                <h6 class="fw-bold mb-0"><i class="fa-solid fa-map-pin text-primary me-2"></i>Pratinjau Peta</h6>
                                <span class="text-muted small">Lihat langsung warna dan opasitas yang dipilih.</span>
                            </div>
                            <span class="badge bg-light text-dark border"><i class="fa-solid fa-eye text-primary me-1"></i>Preview</span>
                        </div>
                        <div class="card-body p-3">
                            <div class="preview-map-wrapper">
                                <div id="mapPreview" style="height: 280px; width: 100%; background-color: #e2e8f0;"></div>
                                <div class="map-preview-badge"><i class="fa-solid fa-layer-group text-primary"></i> Live Preview</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info border-0 mb-4" style="border-radius: 12px; background-color: #f0f7ff;">
                        <div class="d-flex">
                            <i class="fa-solid fa-circle-info mt-1 me-3 text-primary"></i>
                            <div class="small">
                                <strong>Catatan:</strong> Nama wilayah yang diatur di sini akan muncul di popup ketika wilayah di peta diklik oleh pengguna.
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('superadmin/geojson') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const range = document.getElementById('opacityRange');
    const value = document.getElementById('opacityValue');
    range.addEventListener('input', () => {
        value.textContent = range.value;
    });

    // Update hex text on color input change
    const colorPicker = document.querySelector('input[type="color"]');
    const colorHex = document.querySelector('input[type="text"][readonly]');
    colorPicker.addEventListener('input', () => {
        colorHex.value = colorPicker.value.toUpperCase();
        updatePreviewStyle();
    });

    range.addEventListener('input', () => {
        value.textContent = range.value;
        updatePreviewStyle();
    });

    let previewMap = null;
    let previewLayer = null;

    function initPreviewMap() {
        if (previewMap) return;

        previewMap = L.map('mapPreview', {
            zoomControl: true,
            attributionControl: false,
            dragging: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            keyboard: false
        }).setView([-0.5059920351014519, 100.74949926873911], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(previewMap);

        fetch('<?= base_url($geojson['file_geojson']) ?>')
            .then(response => response.json())
            .then(data => {
                const color = colorPicker.value;
                const opacity = parseFloat(range.value);

                previewLayer = L.geoJSON(data, {
                    style: function() {
                        return {
                            color: "#000000",
                            weight: 2,
                            opacity: 0.8,
                            fillColor: color,
                            fillOpacity: opacity
                        };
                    }
                }).addTo(previewMap);

                previewMap.fitBounds(previewLayer.getBounds(), { padding: [20, 20] });
            })
            .catch(err => {
                document.getElementById('mapPreview').insertAdjacentHTML('beforeend', '<div class="alert alert-warning m-3">Gagal memuat pratinjau: File GeoJSON tidak ditemukan.</div>');
            });
    }

    function updatePreviewStyle() {
        if (!previewLayer) return;

        const color = colorPicker.value;
        const opacity = parseFloat(range.value);

        previewLayer.setStyle({
            fillColor: color,
            fillOpacity: opacity
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPreviewMap);
    } else {
        initPreviewMap();
    }
</script>
<?= $this->endSection() ?>
