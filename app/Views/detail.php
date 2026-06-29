<?= $this->extend('layout/template_publik') ?>

<?php
$sekolah = $sekolah ?? [
    'foto' => '',
    'nama_sekolah' => '',
    'jenjang' => '',
    'jumlah_siswa' => 0,
    'alamat' => '',
    'latitude' => 0,
    'longitude' => 0,
    'akreditasi' => '',
    'deskripsi_sekolah' => '',
    'website' => ''
];
?>

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
                        <span class="badge <?= $sekolah['jenjang'] == 'SD' ? 'bg-danger' : ($sekolah['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> px-3 py-2 rounded-pill">
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
                        <div class="col-md-6 info-item">
                            <span class="info-label">Akreditasi</span>
                            <div class="info-value">
                                <?= $sekolah['akreditasi'] ?: 'Belum Terakreditasi' ?>
                            </div>
                        </div>
                        <div class="col-md-6 info-item">
                            <span class="info-label">Kategori</span>
                            <div class="info-value text-capitalize">
                                <?= !empty($sekolah['kategori']) ? ($sekolah['kategori'] == 'negri' ? 'Negeri' : 'Swasta') : '-' ?>
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
                <?php if (!empty($sekolah['website'])) : ?>
                    <?php $link = preg_match('/^https?:\/\//i', $sekolah['website']) ? $sekolah['website'] : 'https://' . $sekolah['website']; ?>
                    <div class="mt-3">
                        <a href="<?= $link ?>" target="_blank" class="btn btn-outline-success w-100 rounded-pill fw-semibold">
                            <i class="fa-solid fa-globe me-2"></i> Kunjungi Website Sekolah
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/api/api_maps.js') ?>"></script>
<script>
    // Inisialisasi Peta Detail
    var lat = <?= $sekolah['latitude'] ?>;
    var lng = <?= $sekolah['longitude'] ?>;
    var zoom = 15;

    var map = L.map('detail-map').setView([lat, lng], zoom);

    // Dynamic Base Layers
    var baseMaps = {
        "Standard Map": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }),
        "Satellite View": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        })
    };

    // Inject MapTiler layers
    if (typeof window.getMapTilerLayers === 'function') {
        Object.assign(baseMaps, window.getMapTilerLayers());
    }

    // Load saved basemap or default
    var savedBasemap = localStorage.getItem('selectedBasemap') || "Standard Map";
    if (!baseMaps[savedBasemap]) savedBasemap = "Standard Map";

    baseMaps[savedBasemap].addTo(map);

    var redIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    var blueIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    var lightblueIcon = L.icon({
        iconUrl: '<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [50, 60],
        iconAnchor: [25, 60],
        popupAnchor: [0, -50],
        shadowSize: [41, 41]
    });

    var markers = {};
    var geojsonLayers = {};
    var geojsonConfig = {}; // For dynamic zoom opacity

    var iconSekolah = <?= $sekolah['jenjang'] == 'SD' ? 'redIcon' : ($sekolah['jenjang'] == 'SMP' ? 'blueIcon' : 'lightblueIcon') ?>;

    var markerSekolah = L.marker([lat, lng], {
            icon: iconSekolah
        }).addTo(map)
        .bindPopup('<b><?= $sekolah['nama_sekolah'] ?></b><br><small>Akreditasi: <?= $sekolah['akreditasi'] ?: 'Belum Terakreditasi' ?></small>').openPopup();
    
    markers[<?= $sekolah['id_sekolah'] ?>] = markerSekolah;

    // Render GeoJSON Layers (Wilayah)
    <?php if (!empty($active_geojson)) : ?>
        <?php foreach ($active_geojson as $gj) : ?>
            fetch('<?= base_url($gj['file_geojson']) ?>')
                .then(response => response.json())
                .then(data => {
                    var layer = L.geoJSON(data, {
                            style: function(feature) {
                                return {
                                    color: "#000000", // Black boundary
                                    weight: 1.5,
                                    opacity: 0.8, // Initial stroke opacity
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

                    // Check localStorage for visibility preference
                    var isVisible = localStorage.getItem('geojson_vis_<?= $gj['id_geojson'] ?>');
                    if (isVisible === null || isVisible === 'true') {
                        layer.addTo(map);
                    }

                    // Apply initial zoom-based opacity
                    updateGeoJsonOpacity(map.getZoom());

                    // Sync school visibility
                    setTimeout(updateMarkersVisibility, 100);
                });
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

    /**
     * Point-in-Polygon Synchronization Logic
     */
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
        var lat = latlng.lat, lng = latlng.lng;
        var coords = polygon.getLatLngs();
        function checkInside(points) {
            if (points.length > 0 && Array.isArray(points[0]) && !points[0].hasOwnProperty('lat')) {
                for (var i = 0; i < points.length; i++) if (checkInside(points[i])) return true;
                return false;
            }
            var inside = false;
            for (var i = 0, j = points.length - 1; i < points.length; j = i++) {
                var xi = points[i].lat, yi = points[i].lng;
                var xj = points[j].lat, yj = points[j].lng;
                var intersect = ((yi > lng) != (yj > lng)) && (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);
                if (intersect) inside = !inside;
            }
            return inside;
        }
        return checkInside(coords);
    }

    function updateMarkersVisibility() {
        Object.keys(markers).forEach(function(id) {
            var marker = markers[id];
            var latlng = marker.getLatLng();
            var shouldHide = false;

            Object.keys(geojsonLayers).forEach(function(gjId) {
                var isVisible = localStorage.getItem('geojson_vis_' + gjId);
                if (isVisible === 'false') {
                    if (isLatLngInLayer(latlng, geojsonLayers[gjId])) {
                        shouldHide = true;
                    }
                }
            });

            if (shouldHide) {
                if (map.hasLayer(marker)) map.removeLayer(marker);
            } else {
                if (!map.hasLayer(marker)) marker.addTo(map);
            }
        });
    }
</script>
<?= $this->endSection() ?>