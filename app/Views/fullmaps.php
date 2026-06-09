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

        .map-overlay > * {
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
            bottom: 150px !important; /* Make room for legend if needed */
        }
        .leaflet-control-layers {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        /* Responsive Settings */
        @media (max-width: 768px) {
            .overlay-top-left {
                width: 280px;
                top: 10px;
                left: 10px;
            }
            .overlay-top-center {
                display: none; /* Hide title on mobile to save space */
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
        <a href="<?= base_url('/') ?>" class="glass-panel back-button">
            <i class="fa-solid fa-arrow-left me-2 text-primary"></i> Beranda
        </a>

        <div class="glass-panel school-panel">
            <div class="school-panel-header">
                <h6 class="fw-bold mb-2"><i class="fa-solid fa-list-check text-primary me-2"></i>Daftar Sekolah</h6>
                <input type="text" id="schoolSearch" class="form-control form-control-sm rounded-pill border-0 bg-light px-3" placeholder="Nama atau alamat sekolah...">
            </div>
            <div class="school-panel-content">
                <?php if (!empty($sekolah_list)): ?>
                    <?php foreach ($sekolah_list as $sk): ?>
                        <div class="school-item" onclick="focusOnSchool(<?= $sk['id_sekolah'] ?>, this)">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : 'bg-primary' ?> me-2" style="font-size: 0.65rem;"><?= $sk['jenjang'] ?></span>
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
                <i class="fa-solid fa-earth-asia text-primary me-2"></i> Peta Sebaran Sekolah (Full Mode)
            </h6>
        </div>
    </div>

    <!-- Bottom Right: Legend -->
    <div class="map-overlay overlay-bottom-right">
        <div class="glass-panel legend-card">
            <h6 class="fw-bold mb-2" style="font-size: 0.85rem;">Legenda</h6>
            <div class="d-flex align-items-center mb-1" style="font-size: 0.8rem;">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; margin-right: 10px;"></div>
                <span>Sekolah Dasar (SD)</span>
            </div>
            <div class="d-flex align-items-center" style="font-size: 0.8rem;">
                <div style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6; margin-right: 10px;"></div>
                <span>Sekolah Menengah (SMP)</span>
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
        }).setView([-0.4795, 100.6274], 14);

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Layers
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        L.control.layers({
            "Standard Map": osm,
            "Satellite View": googleHybrid
        }, null, { position: 'bottomright' }).addTo(map);

        // Marker Icons
        var createIcon = function(color) {
            return L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-' + color + '.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
        };

        var redIcon = createIcon('red');
        var blueIcon = createIcon('blue');

        // Add Data
        <?php if (!empty($sekolah_list)): ?>
            <?php foreach ($sekolah_list as $sk): ?>
                <?php if (!empty($sk['latitude']) && !empty($sk['longitude'])): ?>
                    var icon = <?= $sk['jenjang'] == 'SD' ? 'redIcon' : 'blueIcon' ?>;
                    
                    var marker = L.marker([<?= $sk['latitude'] ?>, <?= $sk['longitude'] ?>], { icon: icon })
                        .addTo(map)
                        .bindPopup(`
                            <div class="custom-popup">
                                <img src="<?= $sk['foto'] ? base_url('uploads/sekolah/' . $sk['foto']) : 'https://via.placeholder.com/250x140?text=No+Image' ?>">
                                <div class="popup-info">
                                    <div class="badge <?= $sk['jenjang'] == 'SD' ? 'bg-danger' : 'bg-primary' ?> mb-2"><?= $sk['jenjang'] ?></div>
                                    <h6 class="fw-bold mb-1"><?= $sk['nama_sekolah'] ?></h6>
                                    <p class="text-muted small mb-3"><i class="fa-solid fa-location-dot me-1"></i> <?= $sk['alamat'] ?></p>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <small class="text-muted"><i class="fa-solid fa-users"></i> <?= number_format($sk['jumlah_siswa'] ?? 0) ?></small>
                                        <a href="<?= base_url('sekolah/' . $sk['id_sekolah']) ?>" class="btn btn-primary btn-sm rounded-pill px-3" style="font-size: 0.7rem;">Detail</a>
                                    </div>
                                </div>
                            </div>
                        `, { className: 'modern-leaflet-popup', maxWidth: 260 });

                    markers[<?= $sk['id_sekolah'] ?>] = marker;
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        // Interaction
        function focusOnSchool(id, element) {
            if (markers[id]) {
                var m = markers[id];
                map.setView(m.getLatLng(), 17, { animate: true, duration: 1.5 });
                m.openPopup();

                $('.school-item').removeClass('active');
                $(element).addClass('active');

                // On mobile, maybe shrink the panel after selection?
                // For now just focus.
            }
        }

        $('#schoolSearch').on('keyup', function() {
            var v = $(this).val().toLowerCase();
            $('.school-item').each(function() {
                var match = $(this).text().toLowerCase().indexOf(v) > -1;
                $(this).toggle(match);
            });
        });
    </script>
</body>

</html>