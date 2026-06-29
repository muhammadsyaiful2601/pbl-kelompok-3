<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= $title ?? 'Peta Sebaran Sekolah'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url('adminlte/css/adminlte.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="<?= base_url('assets/api/api_maps.js') ?>"></script>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
            background-color: #f1f5f9;
        }

        #map {
            height: 100vh;
            width: 100vw;
            z-index: 1;
        }

        /* Overlay System */
        .map-overlay {
            position: absolute;
            z-index: 1000;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .map-overlay>* {
            pointer-events: auto;
        }

        .overlay-top-left {
            top: 20px;
            left: 20px;
            width: 350px;
            max-width: calc(100vw - 40px);
        }

        .overlay-top-center {
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: fit-content;
        }

        .overlay-bottom-right {
            bottom: 30px;
            right: 20px;
            width: fit-content;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        /* Components */
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            width: fit-content;
        }

        .back-button:hover {
            transform: translateX(-3px);
            color: #2563eb;
        }

        .school-panel {
            display: flex;
            flex-direction: column;
            max-height: 70vh;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top left;
        }

        .school-panel.collapsed {
            max-height: 0;
            opacity: 0;
            transform: scaleY(0.95);
            margin-top: -15px;
            pointer-events: none;
        }

        .toggle-panel-btn {
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
        }

        .toggle-panel-btn:hover {
            background: white;
            color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .toggle-panel-btn i {
            transition: transform 0.4s ease;
        }

        .toggle-panel-btn.active i {
            transform: rotate(180deg);
        }

        .top-nav-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .school-panel-header {
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .school-panel-content {
            flex: 1;
            overflow-y: auto;
            padding: 10px 20px 20px;
        }

        .title-badge {
            padding: 10px 25px;
            white-space: nowrap;
        }

        .legend-card {
            padding: 15px 20px;
        }

        /* School Items */
        .school-item {
            padding: 12px;
            border-radius: 12px;
            border: 1px solid transparent;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.5);
        }

        .school-item:hover {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .school-item.active {
            background: #eff6ff;
            border-color: #3b82f6;
        }

        /* Modern Popup Styling */
        .modern-leaflet-popup .leaflet-popup-content-wrapper {
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .modern-leaflet-popup .leaflet-popup-content {
            margin: 0;
            width: 250px !important;
        }

        .custom-popup img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .popup-info {
            padding: 15px;
        }

        /* Custom Scrollbar */
        .school-panel-content::-webkit-scrollbar {
            width: 5px;
        }

        .school-panel-content::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Leaflet Controls Adjustment */
        .leaflet-right {
            right: 10px !important;
        }

        .leaflet-bottom {
            bottom: 150px !important;
            /* Make room for legend if needed */
        }

        .leaflet-control-layers {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .transition-transform {
            transition: transform 0.3s ease;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        /* Responsive Settings */
        @media (max-width: 768px) {
            .overlay-top-left {
                width: 280px;
                top: 10px;
                left: 10px;
            }

            .overlay-top-center {
                display: none;
                /* Hide title on mobile to save space */
            }

            .school-panel {
                max-height: 40vh;
            }

            .legend-card {
                padding: 10px 15px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .overlay-top-left {
                width: calc(100vw - 20px);
            }

            .school-panel {
                max-height: 30vh;
            }
        }
    </style>
</head>

<body>

    <div id="map"></div>

    <!-- Top Left: Navigation & School List -->
    <div class="map-overlay overlay-top-left">
        <div class="top-nav-container">
            <a href="<?= base_url('/') ?>" class="glass-panel back-button">
                <i class="fa-solid fa-arrow-left me-2 text-primary"></i> Beranda
            </a>
            <div id="toggleSchoolPanel" class="glass-panel toggle-panel-btn" title="Toggle Daftar Sekolah">
                <i class="fa-solid fa-chevron-up"></i>
            </div>
        </div>

        <div class="glass-panel school-panel">
            <div class="school-panel-header">
                <h6 class="fw-bold mb-2"><i class="fa-solid fa-list-check text-primary me-2"></i>Daftar Sekolah</h6>

                <!-- Jenjang Filter Buttons -->
                <div class="btn-group w-100 mb-3 p-1 bg-light rounded-pill border-0" role="group">
                    <button type="button" class="btn btn-xs btn-white active rounded-pill fw-bold filter-jenjang" style="font-size: 0.75rem;" data-jenjang="Semua">Semua</button>
                    <button type="button" class="btn btn-xs btn-white rounded-pill fw-bold filter-jenjang" style="font-size: 0.75rem;" data-jenjang="SD">SD</button>
                    <button type="button" class="btn btn-xs btn-white rounded-pill fw-bold filter-jenjang" style="font-size: 0.75rem;" data-jenjang="SMP">SMP</button>
                    <button type="button" class="btn btn-xs btn-white rounded-pill fw-bold filter-jenjang" style="font-size: 0.75rem;" data-jenjang="TK">TK</button>
                </div>

                <input type="text" id="schoolSearch" class="form-control form-control-sm rounded-pill border-0 bg-light px-3" placeholder="Nama atau alamat sekolah...">
            </div>
            <div class="school-panel-content">
                <?php if (!empty($sekolah_list)): ?>
                    <?php foreach ($sekolah_list as $sk): ?>
                        <div class="school-item" data-jenjang="<?= $sk['jenjang'] ?>" onclick="focusOnSchool(<?= $sk['id_sekolah'] ?>, this)">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : ($sk['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> me-2" style="font-size: 0.65rem;"><?= $sk['jenjang'] ?></span>
                                <h6 class="fw-bold mb-0 text-dark small"><?= $sk['nama_sekolah'] ?></h6>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.72rem; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                <i class="fa-solid fa-location-dot me-1"></i> <?= $sk['alamat'] ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-circle-exclamation mb-2"></i>
                        <p class="small mb-0">Belum ada data.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Top Center: Title Badge -->
    <div class="map-overlay overlay-top-center">
        <div class="glass-panel title-badge">
            <h6 class="mb-0 fw-bold text-slate-800">
                <i class="fa-solid fa-earth-asia text-primary me-2"></i> Peta Geospasial Sebaran Sekolah Kabupaten Tanah Datar
            </h6>
        </div>
    </div>

    <!-- Bottom Right: Basemap Selector & Legend -->
    <div class="map-overlay overlay-bottom-right">
        <!-- Layer Management Panel -->
        <div class="glass-panel mb-2 overflow-hidden" style="width: 200px;">
            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom cursor-pointer toggle-layer-content" style="background: rgba(255,255,255,0.5);">
                <label class="small fw-bold mb-0 text-muted" style="cursor: pointer;"><i class="fa-solid fa-layer-group me-1"></i>Layer</label>
                <i class="fa-solid fa-chevron-up small text-muted transition-transform" id="layerPanelIcon"></i>
            </div>
            <div id="layerPanelContent" class="px-2 py-1 transition-all" style="max-height: 200px; overflow-y: auto;">
                <?php if (!empty($active_geojson)) : ?>
                    <?php foreach ($active_geojson as $gj) : ?>
                        <div class="form-check form-switch mb-1 ms-2">
                            <input class="form-check-input geojson-toggle" type="checkbox" role="switch" id="toggle_<?= $gj['id_geojson'] ?>" data-id="<?= $gj['id_geojson'] ?>" checked>
                            <label class="form-check-label small text-dark" for="toggle_<?= $gj['id_geojson'] ?>" style="cursor: pointer;"><?= $gj['nama_geojson'] ?></label>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <small class="text-muted italic d-block text-center py-2">Tidak ada layer aktif.</small>
                <?php endif; ?>
            </div>
        </div>

        <!-- Basemap Selection Panel -->
        <div class="glass-panel p-2 mb-2" style="width: 200px;">
            <label class="small fw-bold mb-1 d-block px-2 text-muted"><i class="fa-solid fa-map me-1"></i> Ganti Tema Peta</label>
            <select id="basemapSelector" class="form-select form-select-sm border-0 bg-light rounded-3">
                <option value="Standard Map">Standar (OSM)</option>
                <option value="Satellite View">Satelit (Google)</option>
                <!-- MapTiler layers will be injected here via JS -->
            </select>
        </div>

        <div class="glass-panel legend-card">
            <h6 class="fw-bold mb-2" style="font-size: 0.85rem;">Legenda</h6>
            <div class="d-flex align-items-center mb-1" style="font-size: 0.8rem;">
                <img src="<?= base_url('marker/' . rawurlencode('logo SD.png')) ?>" style="width: 20px; height: 24px; margin-right: 10px; object-fit: contain;">
                <span>Sekolah Dasar (SD)</span>
            </div>
            <div class="d-flex align-items-center mb-1" style="font-size: 0.8rem;">
                <img src="<?= base_url('marker/' . rawurlencode('Logo smp.png')) ?>" style="width: 20px; height: 24px; margin-right: 10px; object-fit: contain;">
                <span>Sekolah Menengah (SMP)</span>
            </div>
            <div class="d-flex align-items-center" style="font-size: 0.8rem;">
                <img src="<?= base_url('marker/' . rawurlencode('logo TK.png')) ?>" style="width: 20px; height: 24px; margin-right: 10px; object-fit: contain;">
                <span>Taman Kanak-kanak (TK)</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        var markers = {};

        // Setup Map
        var map = L.map('map', {
            zoomControl: false,
            attributionControl: false
        }).setView([-0.5059920351014519, 100.74949926873911], 12);

        L.control.zoom({
            position: 'bottomright'
        }).addTo(map);

        // Base Layers Initialization
        var baseMaps = {
            "Standard Map": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap'
            }),
            "Satellite View": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '&copy; Google Maps'
            })

            // "Satellite View": L.tileLayer('https://api.maptiler.com/maps/hybrid-v4/{z}/{x}/{y}.jpg?key=VMd1gieKnl5V7Z3FAPeW', {
            //        maxZoom: 20,
            //         attribution: '&copy; <a href="https://www.maptiler.com/copyright/">MapTiler</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            // })
        };

        // Inject MapTiler layers from api_maps.js helper
        if (typeof window.getMapTilerLayers === 'function') {
            var maptilerLayers = window.getMapTilerLayers();
            Object.assign(baseMaps, maptilerLayers);

            // Populate selector with all available layers
            var $selector = $('#basemapSelector');
            // Check if MapTiler layers exist, then add them to dropdown
            Object.keys(maptilerLayers).forEach(function(name) {
                $selector.append($('<option>', {
                    value: name,
                    text: name
                }));
            });
        }

        // Initialize with saved basemap or default
        var savedBasemap = localStorage.getItem('selectedBasemap') || "Standard Map";
        if (!baseMaps[savedBasemap]) savedBasemap = "Standard Map";

        baseMaps[savedBasemap].addTo(map);
        $('#basemapSelector').val(savedBasemap);

        // Handle Selector Change
        $('#basemapSelector').on('change', function() {
            var selected = $(this).val();

            // Remove all current base layers
            Object.values(baseMaps).forEach(function(layer) {
                if (map.hasLayer(layer)) map.removeLayer(layer);
            });

            // Add selected
            if (baseMaps[selected]) {
                baseMaps[selected].addTo(map);
                localStorage.setItem('selectedBasemap', selected);
            }
        });

        // Marker Icons using local logo files
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

        // Add Data
        <?php if (!empty($sekolah_list)): ?>
            <?php foreach ($sekolah_list as $sk): ?>
                <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])): ?>
                    var icon = <?= $sk['jenjang'] == 'SD' ? 'redIcon' : ($sk['jenjang'] == 'SMP' ? 'blueIcon' : 'lightblueIcon') ?>;

                    var marker = L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], {
                            icon: icon,
                            jenjang: '<?= $sk['jenjang'] ?>',
                            nama: '<?= addslashes($sk['nama_sekolah']) ?>'
                        })
                        .addTo(map)
                        .bindPopup(`
                            <div class="custom-popup">
                                <img src="<?= $sk['foto'] ? base_url('uploads/sekolah/' . $sk['foto']) : 'https://via.placeholder.com/250x140?text=No+Image' ?>">
                                <div class="popup-info">
                                    <div class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : ($sk['jenjang'] == 'SMP' ? 'bg-primary' : 'bg-info text-dark') ?> mb-2"><?= $sk['jenjang'] ?></div>
                                    <h6 class="fw-bold mb-1"><?= $sk['nama_sekolah'] ?></h6>
                                    <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i> <?= $sk['alamat'] ?></p>
                                    <p class="text-muted small mb-3"><strong>Akreditasi:</strong> <?= $sk['akreditasi'] ?: 'Belum Terakreditasi' ?></p>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <small class="text-muted"><i class="fa-solid fa-users"></i> <?= number_format($sk['jumlah_siswa'] ?? 0) ?></small>
                                        <a href="<?= base_url('sekolah/' . $sk['id_sekolah']) ?>" class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 0.7rem;">Detail</a>
                                    </div>
                                </div>
                            </div>
                        `, {
                            className: 'modern-leaflet-popup',
                            maxWidth: 260
                        });

                    markers[<?= $sk['id_sekolah'] ?>] = marker;
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        // Interaction
        function focusOnSchool(id, element) {
            if (markers[id]) {
                var m = markers[id];
                map.setView(m.getLatLng(), 17, {
                    animate: true,
                    duration: 1.5
                });
                m.openPopup();

                $('.school-item').removeClass('active');
                $(element).addClass('active');

                // On mobile, maybe shrink the panel after selection?
                // For now just focus.
            }
        }

        // Filter Selection
        var currentFilter = 'Semua';

        $('.filter-jenjang').on('click', function() {
            $('.filter-jenjang').removeClass('active btn-white').addClass('btn-light');
            $(this).addClass('active btn-white').removeClass('btn-light');
            currentFilter = $(this).data('jenjang');

            applyFilters();
        });

        $('#schoolSearch').on('keyup', function() {
            applyFilters();
        });

        function applyFilters() {
            var searchVal = $('#schoolSearch').val().toLowerCase();

            // Filter List Items
            $('.school-item').each(function() {
                var nameMatch = $(this).text().toLowerCase().indexOf(searchVal) > -1;
                var jenjang = $(this).data('jenjang');
                var jenjangMatch = (currentFilter === 'Semua' || jenjang === currentFilter);

                if (nameMatch && jenjangMatch) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            // Update Markers Visibility
            updateMarkersVisibility();
        }

        // Toggle Panel Functionality
        $('#toggleSchoolPanel').on('click', function() {
            $(this).toggleClass('active');
            var $panel = $('.school-panel');
            $panel.toggleClass('collapsed');

            var isCollapsed = $panel.hasClass('collapsed');
            $(this).find('i').attr('class', isCollapsed ? 'fa-solid fa-chevron-down' : 'fa-solid fa-chevron-up');

            // Save state
            localStorage.setItem('schoolPanelCollapsed', isCollapsed);
        });

        // Restore state on load
        $(document).ready(function() {
            if (localStorage.getItem('schoolPanelCollapsed') === 'true') {
                $('#toggleSchoolPanel').addClass('active');
                $('.school-panel').addClass('collapsed');
                $('#toggleSchoolPanel').find('i').attr('class', 'fa-solid fa-chevron-down');
            }
        });

        // Global storage for GeoJSON layers
        var geojsonLayers = {};
        var geojsonConfig = {}; // Stores original style settings for dynamic zoom opacity

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
                                        weight: 2,
                                        opacity: 0.8, // Increased opacity for better visibility
                                        fillOpacity: <?= $gj['opacity_geojson'] ?>,
                                        fillColor: "<?= $gj['warna_geojson'] ?>"
                                    };
                                }
                            })
                            .bindPopup(" <?= $gj['nama_geojson'] ?>")
                            .on('mouseover', function(e) {
                                var config = geojsonConfig[<?= $gj['id_geojson'] ?>];
                                if (map.getZoom() < 15) {
                                    this.setStyle({
                                        fillOpacity: Math.min(1, config.fillOpacity + 0.2)
                                    });
                                }
                            })
                            .on('mouseout', function(e) {
                                var config = geojsonConfig[<?= $gj['id_geojson'] ?>];
                                this.setStyle({
                                    fillOpacity: config ? config.fillOpacity : <?= $gj['opacity_geojson'] ?>
                                });
                            });

                        geojsonLayers[<?= $gj['id_geojson'] ?>] = layer;
                        geojsonConfig[<?= $gj['id_geojson'] ?>] = {
                            fillOpacity: <?= $gj['opacity_geojson'] ?>,
                            opacity: 0.8, // Initial stroke opacity
                            color: "#000000"
                        };

                        // Wait a bit to ensure layer is fully ready before initial visibility check
                        setTimeout(updateMarkersVisibility, 100);

                        // Check localStorage for visibility preference
                        var isVisible = localStorage.getItem('geojson_vis_<?= $gj['id_geojson'] ?>');
                        if (isVisible === null || isVisible === 'true') {
                            layer.addTo(map);
                            $('#toggle_<?= $gj['id_geojson'] ?>').prop('checked', true);
                        } else {
                            $('#toggle_<?= $gj['id_geojson'] ?>').prop('checked', false);
                        }

                        // Apply initial zoom-based opacity
                        updateGeoJsonOpacity(map.getZoom());
                    });
            <?php endforeach; ?>
        <?php endif; ?>

        /**
         * Update GeoJSON opacity based on zoom level to see terrain better
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
                    newStrokeOpacity = 0.2;
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

        // Zoom change listener
        map.on('zoomend', function() {
            updateGeoJsonOpacity(map.getZoom());
        });

        /**
         * Helper to check if a LatLng is inside a Leaflet layer (Polygon/MultiPolygon)
         */
        function isLatLngInLayer(latlng, layer) {
            if (!layer) return false;

            var found = false;
            layer.eachLayer(function(l) {
                if (l instanceof L.Polygon || l instanceof L.Polyline) { // Polyline check just in case, though usually Polygons
                    if (isLatLngInPolygon(latlng, l)) {
                        found = true;
                    }
                }
            });
            return found;
        }

        /**
         * Ray-casting algorithm to check if point is in polygon
         */
        function isLatLngInPolygon(latlng, polygon) {
            var lat = latlng.lat;
            var lng = latlng.lng;
            var coords = polygon.getLatLngs();

            // Recursive function to handle nested arrays for Holes/MultiPolygons
            function checkInside(points) {
                if (points.length > 0 && Array.isArray(points[0]) && !points[0].hasOwnProperty('lat')) {
                    for (var i = 0; i < points.length; i++) {
                        if (checkInside(points[i])) return true;
                    }
                    return false;
                }

                var inside = false;
                for (var i = 0, j = points.length - 1; i < points.length; j = i++) {
                    var xi = points[i].lat,
                        yi = points[i].lng;
                    var xj = points[j].lat,
                        yj = points[j].lng;
                    var intersect = ((yi > lng) != (yj > lng)) &&
                        (lat < (xj - xi) * (lng - yi) / (yj - yi) + xi);
                    if (intersect) inside = !inside;
                }
                return inside;
            }

            return checkInside(coords);
        }

        /**
         * Update visibility of markers based on GeoJSON layer visibility AND Jenjang/Search filters
         */
        function updateMarkersVisibility() {
            var searchVal = $('#schoolSearch').val().toLowerCase();

            Object.keys(markers).forEach(function(schoolId) {
                var marker = markers[schoolId];
                var latlng = marker.getLatLng();
                var shouldHide = false;

                // 1. Check Jenjang and Search Filter
                var jenjang = marker.options.jenjang;
                var name = marker.options.nama ? marker.options.nama.toLowerCase() : '';

                if (currentFilter !== 'Semua' && jenjang !== currentFilter) {
                    shouldHide = true;
                }
                if (searchVal && name.indexOf(searchVal) === -1) {
                    shouldHide = true;
                }

                // 2. Check GeoJSON layer visibility (if not already hidden)
                if (!shouldHide) {
                    Object.keys(geojsonLayers).forEach(function(gjId) {
                        var isChecked = $('#toggle_' + gjId).is(':checked');
                        if (!isChecked) {
                            if (isLatLngInLayer(latlng, geojsonLayers[gjId])) {
                                shouldHide = true;
                            }
                        }
                    });
                }

                if (shouldHide) {
                    if (map.hasLayer(marker)) {
                        map.removeLayer(marker);
                    }
                } else {
                    if (!map.hasLayer(marker)) {
                        marker.addTo(map);
                    }
                }
            });
        }

        // Handle GeoJSON Toggle
        $('.geojson-toggle').on('change', function() {
            var id = $(this).data('id');
            var isChecked = $(this).is(':checked');

            if (geojsonLayers[id]) {
                if (isChecked) {
                    geojsonLayers[id].addTo(map);
                } else {
                    map.removeLayer(geojsonLayers[id]);
                }
                localStorage.setItem('geojson_vis_' + id, isChecked);

                // Update markers visibility whenever a layer is toggled
                updateMarkersVisibility();
            }
        });

        // Toggle Layer Panel Visibility
        $('.toggle-layer-content').on('click', function() {
            var $content = $('#layerPanelContent');
            var $icon = $('#layerPanelIcon');

            $content.slideToggle(300);
            $(this).toggleClass('active');

            var isCollapsed = $(this).hasClass('active');
            $icon.css('transform', isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)');

            localStorage.setItem('layerPanelCollapsed', isCollapsed);
        });

        // Restore Layer Panel State
        $(document).ready(function() {
            if (localStorage.getItem('layerPanelCollapsed') === 'true') {
                $('.toggle-layer-content').addClass('active');
                $('#layerPanelContent').hide();
                $('#layerPanelIcon').css('transform', 'rotate(180deg)');
            }
        });
    </script>
</body>

</html>