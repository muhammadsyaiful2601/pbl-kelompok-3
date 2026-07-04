
(function (window, document) {
  'use strict';

  window.MAPTILER_KEY = window.MAPTILER_KEY || 'VMd1gieKnl5V7Z3FAPeW';

  // returns a fresh set of L.tileLayer instances (one per call)
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

  // Apply basemap by key; removes any layers from the provided layersObj currently on the map
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
    // store pointer to current
    map._currentBasemapKey = key;
  };

})(window, document);