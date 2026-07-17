/**
 * API Maps - PBL Kelompok 3
 * Berisi semua fungsi dan konfigurasi yang berhubungan dengan Leaflet Map
 * Dipisahkan dari view untuk clean code dan reusability
 */
(function (window, document) {
  'use strict';

  // ===================== KONFIGURASI =====================

  window.MAPTILER_KEY = window.MAPTILER_KEY || 'VMd1gieKnl5V7Z3FAPeW';

  // Konfigurasi marker icon (harus di-set dari PHP view sebelum script ini di-load)
  window.MAP_CONFIG = window.MAP_CONFIG || {
    markerIcons: {
      SD: '',
      SMP: '',
      TK: ''
    }
  };

  // ===================== BASE MAPS / TILE LAYERS =====================

  /**
   * Mendapatkan base maps default (OSM + Google Satellite)
   */
  window.getDefaultBaseMaps = function () {
    return {
      "Standard Map": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
      }),
      "Satellite View": L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
        attribution: '&copy; Google Maps'
      })
    };
  };

  /**
   * Mendapatkan semua base maps (default + MapTiler)
   */
  window.getAllBaseMaps = function () {
    var baseMaps = window.getDefaultBaseMaps();
    if (typeof window.getMapTilerLayers === 'function') {
      Object.assign(baseMaps, window.getMapTilerLayers());
    }
    return baseMaps;
  };

  /**
   * Memuat base map yang tersimpan di localStorage, atau default
   * @param {Object} baseMaps - Kumpulan base maps
   * @param {L.Map} map - Instance Leaflet map
   * @param {string} [defaultKey] - Key default jika tidak ada di localStorage
   */
  window.loadSavedBasemap = function (baseMaps, map, defaultKey) {
    defaultKey = defaultKey || "Standard Map";
    var saved = localStorage.getItem('selectedBasemap') || defaultKey;
    if (!baseMaps[saved]) saved = defaultKey;
    baseMaps[saved].addTo(map);
    return saved;
  };

  /**
   * Ganti base map pada map
   * @param {L.Map} map - Instance Leaflet map
   * @param {Object} baseMaps - Kumpulan base maps
   * @param {string} key - Key base map yang dipilih
   */
  window.switchBasemap = function (map, baseMaps, key) {
    if (!baseMaps[key]) return;
    Object.keys(baseMaps).forEach(function (k) {
      if (map.hasLayer(baseMaps[k])) map.removeLayer(baseMaps[k]);
    });
    baseMaps[key].addTo(map);
    localStorage.setItem('selectedBasemap', key);
  };

  // ===================== MAPTILER LAYERS =====================

  /**
   * Mendapatkan layer-layer MapTiler
   */
  window.getMapTilerLayers = function (opts) {
    opts = opts || {};
    var key = window.MAPTILER_KEY;
    var crossOrigin = (opts.crossOrigin !== undefined) ? opts.crossOrigin : true;
    var layers = {};

    layers['Peta Jalan (MapTiler)'] = L.tileLayer('https://api.maptiler.com/maps/basic-v2/{z}/{x}/{y}.png?key=' + key, {
      attribution: '&copy; MapTiler &copy; OpenStreetMap contributors',
      crossOrigin: crossOrigin
    });

    layers['Peta Jalan Detail (MapTiler)'] = L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=' + key, {
      attribution: '&copy; MapTiler &copy; OpenStreetMap contributors',
      crossOrigin: crossOrigin
    });

    layers['Citra Satelit (MapTiler)'] = L.tileLayer('https://api.maptiler.com/maps/hybrid/{z}/{x}/{y}.jpg?key=' + key, {
      attribution: '&copy; MapTiler &copy; OpenStreetMap contributors',
      crossOrigin: crossOrigin
    });

    return layers;
  };

  /**
   * Apply basemap by key; removes any layers from the provided layersObj currently on the map
   */
  window.applyBasemap = function (map, layersObj, key) {
    if (!map || !layersObj) return;
    try {
      Object.values(layersObj).forEach(function (l) {
        if (map.hasLayer(l)) map.removeLayer(l);
      });
    } catch (e) {
      // ignore
    }
    var layer = layersObj[key];
    if (layer) map.addLayer(layer);
    map._currentBasemapKey = key;
  };

  // ===================== CLUSTER FUNCTIONS =====================

  /**
   * Buat MarkerClusterGroup dengan konfigurasi default
   * @param {Object} [opts] - Opsi tambahan untuk MarkerClusterGroup
   * @returns {L.MarkerClusterGroup}
   */
  window.createClusterGroup = function (opts) {
    opts = opts || {};
    var defaultOpts = {
      chunkedLoading: true,
      maxClusterRadius: 50,
      spiderfyOnMaxZoom: true,
      showCoverageOnHover: false,
      zoomToBoundsOnClick: true,
      disableClusteringAtZoom: 17,
      removeOutsideVisibleBounds: true,
      animate: true,
      animateAddingMarkers: true,
      iconCreateFunction: function (cluster) {
        var childCount = cluster.getChildCount();
        var size = 'small';
        if (childCount < 10) {
          size = 'small';
        } else if (childCount < 50) {
          size = 'medium';
        } else {
          size = 'large';
        }
        return L.divIcon({
          html: '<div><span>' + childCount + '</span></div>',
          className: 'marker-cluster marker-cluster-' + size,
          iconSize: L.point(40, 40)
        });
      }
    };
    // Merge user options
    Object.keys(opts).forEach(function (k) {
      defaultOpts[k] = opts[k];
    });
    return L.markerClusterGroup(defaultOpts);
  };

  /**
   * Update cluster: hapus semua marker dari cluster, lalu tambahkan kembali
   * marker yang visible (tidak di-filter)
   * @param {L.MarkerClusterGroup} clusterGroup - Cluster group
   * @param {Object} markersObj - Object berisi semua marker {id: marker}
   * @param {Function} filterFn - Fungsi filter(marker) => true jika visible
   */
  window.updateClusterMarkers = function (clusterGroup, markersObj, filterFn) {
    clusterGroup.clearLayers();
    Object.keys(markersObj).forEach(function (id) {
      var marker = markersObj[id];
      if (filterFn(marker)) {
        clusterGroup.addLayer(marker);
      }
    });
  };

  /**
   * Cari marker dalam cluster group berdasarkan ID (untuk focusOnSchool)
   * @param {L.MarkerClusterGroup} clusterGroup - Cluster group
   * @param {number|string} markerId - ID marker yang dicari
   * @param {Object} markersObj - Object berisi semua marker {id: marker}
   * @returns {L.Marker|null}
   */
  window.findMarkerInCluster = function (clusterGroup, markerId, markersObj) {
    return markersObj[markerId] || null;
  };

  /**
   * Zoom ke marker tertentu dan buka popup, dengan dukungan cluster
   * @param {L.Map} map - Instance Leaflet map
   * @param {L.MarkerClusterGroup} clusterGroup - Cluster group
   * @param {L.Marker} marker - Marker tujuan
   * @param {number} zoomLevel - Zoom level tujuan (default 17)
   */
  window.zoomToMarker = function (map, clusterGroup, marker, zoomLevel) {
    zoomLevel = zoomLevel || 17;
    // Zoom ke lokasi marker
    map.setView(marker.getLatLng(), zoomLevel, {
      animate: true,
      duration: 1.5
    });
    // Buka popup setelah animasi selesai
    setTimeout(function () {
      marker.openPopup();
    }, 600);
  };

  // ===================== MARKER FUNCTIONS =====================

  /**
   * Hitung ukuran marker berdasarkan zoom level
   */
  window.getMarkerSize = function (zoom) {
    if (zoom >= 17) return { w: 65, h: 78 };
    if (zoom >= 15) return { w: 50, h: 60 };
    if (zoom >= 13) return { w: 38, h: 46 };
    if (zoom >= 11) return { w: 28, h: 34 };
    return { w: 22, h: 27 };
  };

  /**
   * Buat L.icon untuk jenjang tertentu dengan ukuran tertentu
   */
  window.createSchoolIcon = function (jenjang, size) {
    var icons = window.MAP_CONFIG.markerIcons;
    var iconUrl = icons.SD || '';
    if (jenjang === 'SMP') {
      iconUrl = icons.SMP || '';
    } else if (jenjang === 'TK') {
      iconUrl = icons.TK || '';
    }

    var w = size.w;
    var h = size.h;

    return L.icon({
      iconUrl: iconUrl,
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [w, h],
      iconAnchor: [w / 2, h],
      popupAnchor: [0, -h + 10],
      shadowSize: [Math.round(w * 0.82), Math.round(h * 0.68)]
    });
  };

  /**
   * Update ukuran semua marker berdasarkan zoom level
   * @param {Object} markersObj - Object berisi marker-marker
   * @param {number} zoom - Zoom level saat ini
   */
  window.updateMarkerSizes = function (markersObj, zoom) {
    var size = window.getMarkerSize(zoom);
    Object.keys(markersObj).forEach(function (id) {
      var m = markersObj[id];
      var jenjang = m.options.originalJenjang || (m.options.icon && m.options.icon.options && m.options.icon.options.iconUrl
        ? (m.options.icon.options.iconUrl.indexOf('logo SD') > -1 ? 'SD'
          : m.options.icon.options.iconUrl.indexOf('Logo smp') > -1 ? 'SMP' : 'TK')
        : 'SD');
      var newIcon = window.createSchoolIcon(jenjang, size);
      m.setIcon(newIcon);
    });
  };

  // ===================== GEOJSON FUNCTIONS =====================

  /**
   * Update opacity GeoJSON berdasarkan zoom level
   * @param {Object} geojsonLayers - Object berisi layer GeoJSON
   * @param {Object} geojsonConfig - Konfigurasi style original
   * @param {number} zoom - Zoom level
   */
  window.updateGeoJsonOpacity = function (geojsonLayers, geojsonConfig, zoom) {
    Object.keys(geojsonLayers).forEach(function (id) {
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
  };

  // ===================== POINT-IN-POLYGON =====================

  /**
   * Cek apakah suatu koordinat berada di dalam layer polygon
   */
  window.isLatLngInLayer = function (latlng, layer) {
    if (!layer) return false;
    var found = false;
    layer.eachLayer(function (l) {
      if (l instanceof L.Polygon) {
        if (window.isLatLngInPolygon(latlng, l)) found = true;
      }
    });
    return found;
  };

  /**
   * Ray-casting algorithm untuk cek point dalam polygon
   */
  window.isLatLngInPolygon = function (latlng, polygon) {
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
  };

  /**
   * Update visibilitas marker berdasarkan visibilitas layer GeoJSON
   * @param {Object} markersObj - Object berisi marker-marker
   * @param {Object} geojsonLayers - Object berisi layer GeoJSON
   * @param {L.Map} map - Instance Leaflet map
   */
  window.updateMarkersVisibility = function (markersObj, geojsonLayers, map) {
    Object.keys(markersObj).forEach(function (id) {
      var marker = markersObj[id];
      var latlng = marker.getLatLng();
      var shouldHide = false;

      Object.keys(geojsonLayers).forEach(function (gjId) {
        var isVisible = localStorage.getItem('geojson_vis_' + gjId);
        if (isVisible === 'false') {
          if (window.isLatLngInLayer(latlng, geojsonLayers[gjId])) {
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
  };

  /**
   * Fetch dan render GeoJSON layer
   * @param {string} url - URL file GeoJSON
   * @param {Object} styleOpts - Opsi style {color, weight, opacity, fillOpacity, fillColor}
   * @param {string} popupLabel - Label untuk popup
   * @param {Object} geojsonLayers - Object untuk menyimpan layer (akan diisi)
   * @param {Object} geojsonConfig - Object untuk menyimpan konfigurasi (akan diisi)
   * @param {number} layerId - ID layer
   * @param {L.Map} map - Instance Leaflet map
   * @param {Object} [markersObj] - Optional, object marker untuk update visibility
   * @returns {Promise} Promise yang resolve ketika layer selesai di-load
   */
  window.loadGeoJsonLayer = function (url, styleOpts, popupLabel, geojsonLayers, geojsonConfig, layerId, map, markersObj) {
    return fetch(url)
      .then(function (response) { return response.json(); })
      .then(function (data) {
        var layer = L.geoJSON(data, {
          style: function (feature) {
            return {
              color: styleOpts.color || "#000000",
              weight: styleOpts.weight || 2,
              opacity: styleOpts.opacity || 0.8,
              fillOpacity: styleOpts.fillOpacity || 0.3,
              fillColor: styleOpts.fillColor || "#3388ff"
            };
          }
        });

        // Bind popup jika ada label
        if (popupLabel) {
          layer.bindPopup(popupLabel);
        }

        geojsonLayers[layerId] = layer;
        geojsonConfig[layerId] = {
          fillOpacity: styleOpts.fillOpacity || 0.3,
          opacity: styleOpts.opacity || 0.8,
          color: styleOpts.color || "#000000"
        };

        // Cek localStorage untuk preferensi visibilitas
        var isVisible = localStorage.getItem('geojson_vis_' + layerId);
        if (isVisible === null || isVisible === 'true') {
          layer.addTo(map);
        }

        // Trigger initial zoom-based opacity
        window.updateGeoJsonOpacity(geojsonLayers, geojsonConfig, map.getZoom());

        return layer; // Return layer untuk chaining (.then())
      });
  };

})(window, document);