let currentJenjangFilter = 'semua';
let currentKecamatanFilter = 'semua';

/* Cek apakah sekolah berada di dalam layer wilayah GeoJSON */
function isSchoolInGeoJson(school, geojsonLayer) {
    if (!school.latitude || !school.longitude || !geojsonLayer) return false;
    const latlng = L.latLng(school.latitude, school.longitude);
    return window.isLatLngInLayer(latlng, geojsonLayer);
}

/* Fungsi untuk menyaring marker di peta berdasarkan filter yang aktif */
function updateMapMarkers() {
    if (typeof markers === 'undefined' || typeof markerCluster === 'undefined' || typeof map === 'undefined') return;

    var filterFn = function(marker) {
        // Cari ID sekolah dari marker
        var markerId = null;
        Object.keys(markers).forEach(function(id) {
            if (markers[id] === marker) {
                markerId = id;
            }
        });
        
        if (!markerId) return true;
        
        const school = window.sekolahData.find(s => s.id_sekolah == markerId);
        if (!school) return true;

        const jenjang = (school.jenjang || school.type || 'SD').toLowerCase();
        const matchesJenjang = currentJenjangFilter === 'semua' || jenjang === currentJenjangFilter.toLowerCase();

        if (!matchesJenjang) return false;

        let matchesKecamatan = true;
        if (currentKecamatanFilter !== 'semua') {
            const layer = geojsonLayers[currentKecamatanFilter];
            if (layer) {
                matchesKecamatan = isSchoolInGeoJson(school, layer);
            }
        }

        return matchesKecamatan;
    };

    window.updateClusterMarkers(markerCluster, markers, filterFn);
}

/* Fungsi untuk merender daftar sekolah ke elemen HTML (Format Tabel Hover 3D) */
function renderSchoolSearchList() {
    const tableBody = document.getElementById('schoolSearchListTableBody');
    const tableElement = document.getElementById('schoolSearchTable');
    const statusElement = document.getElementById('schoolListStatus');
    const searchKeyword = document.getElementById('searchSchoolInput').value.toLowerCase();

    if (!tableBody || !tableElement || !statusElement) return;
    
    // Bersihkan data baris lama sebelum rendering ulang
    tableBody.innerHTML = '';

    // Lakukan pemfilteran data array global
    const filteredSchools = window.sekolahData.filter(school => {
        const nama = (school.nama_sekolah || school.name || '').toLowerCase();
        const alamat = (school.alamat || school.addr || '').toLowerCase();
        const jenjang = (school.jenjang || school.type || 'SD').toLowerCase();

        const matchesSearch = nama.includes(searchKeyword) || alamat.includes(searchKeyword);
        const matchesJenjang = currentJenjangFilter === 'semua' || jenjang === currentJenjangFilter.toLowerCase();

        let matchesKecamatan = true;
        if (currentKecamatanFilter !== 'semua') {
            const layer = geojsonLayers[currentKecamatanFilter];
            if (layer) {
                matchesKecamatan = isSchoolInGeoJson(school, layer);
            }
        }

        return matchesSearch && matchesJenjang && matchesKecamatan;
    });

    // Validasi kondisi apabila data tidak ditemukan
    if (filteredSchools.length === 0) {
        tableElement.style.display = 'none';
        statusElement.style.display = 'block';
        statusElement.innerHTML = 'Sekolah tidak ditemukan.';
        return;
    }

    // Ubah visibilitas elemen: Tampilkan tabel, sembunyikan status box
    statusElement.style.display = 'none';
    tableElement.style.display = 'table';

    // Sisipkan struktur baris baru secara dinamis
    filteredSchools.forEach(school => {
        const nama = school.nama_sekolah || school.name;
        const alamat = school.alamat || school.addr || 'Alamat belum diatur';
        const jenjang = (school.jenjang || school.type || 'SD').toUpperCase();
        
        // Klasifikasi warna badge Bootstrap berdasarkan jenjang sekolah
        const badgeColor = jenjang === 'SD'
            ? 'bg-danger-subtle text-danger'
            : jenjang === 'SMP'
                ? 'bg-primary-subtle text-primary'
                : 'bg-info-subtle text-info';

        const rowHtml = `
            <tr onclick="focusToMapMatrix(${school.latitude || school.lat}, ${school.longitude || school.lng}, '${nama}')">
                <td class="ps-4 fw-bold text-slate-800">${nama}</td>
                <td>
                    <span class="badge ${badgeColor} px-2.5 py-1.5 rounded font-semibold" style="font-size: 0.75rem;">
                        ${jenjang}
                    </span>
                </td>
                <td class="text-muted text-truncate" style="max-width: 180px;">
                    <i class="fa-solid fa-map-marker-alt text-danger me-1" style="font-size: 0.8rem;"></i> ${alamat}
                </td>
                <td class="text-center pe-4">
                    <button class="btn btn-sm btn-outline-primary py-1 px-2.5" style="font-size: 0.78rem; border-radius: 6px;">
                        <i class="fa-solid fa-eye me-1"></i> Lihat
                    </button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', rowHtml);
    });
}

/* Fungsi untuk mengubah status filter jenjang aktif dan memperbarui daftar */
function filterSearchList(jenjang, buttonElement) {
    currentJenjangFilter = jenjang;

    const buttons = document.querySelectorAll('.filter-btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    if (buttonElement) {
        buttonElement.classList.add('active');
    }

    renderSchoolSearchList();
    updateMapMarkers();
}

/* Fungsi untuk memfilter berdasarkan wilayah GeoJSON (Kecamatan) */
function filterKecamatanList(kecId, zoomToKec = true) {
    currentKecamatanFilter = kecId;

    const selectEl = document.getElementById('filterKecamatanSelect');
    if (selectEl) {
        selectEl.value = kecId;
    }

    // Reset style semua wilayah
    if (typeof geojsonLayers !== 'undefined') {
        Object.keys(geojsonLayers).forEach(id => {
            const layer = geojsonLayers[id];
            const config = geojsonConfig[id];
            if (layer && config) {
                layer.setStyle({
                    weight: 2,
                    color: '#000000'
                });
            }
        });

        // Highlight wilayah terpilih
        if (kecId !== 'semua') {
            const activeLayer = geojsonLayers[kecId];
            if (activeLayer) {
                activeLayer.setStyle({
                    weight: 4,
                    color: '#0d6efd'
                });
                if (zoomToKec && typeof map !== 'undefined') {
                    map.fitBounds(activeLayer.getBounds());
                }
            }
        } else {
            // Reset view jika pilih "Semua"
            if (zoomToKec && typeof map !== 'undefined') {
                map.setView([-0.5059920351014519, 100.74949926873911], 11);
            }
        }
    }

    renderSchoolSearchList();
    updateMapMarkers();
}

/* Fungsi untuk memindahkan fokus tampilan peta koordinat dan menggulir halaman */
function focusToMapMatrix(lat, lng, name) {
    if (typeof map !== 'undefined' && lat && lng) {
        map.setView([lat, lng], 16);
        document.getElementById('peta-section').scrollIntoView({
            behavior: 'smooth'
        });
    } else {
        document.getElementById('peta-section').scrollIntoView({
            behavior: 'smooth'
        });
    }
}

/* Inisialisasi event listener pencarian saat seluruh dokumen HTML selesai dimuat */
document.addEventListener("DOMContentLoaded", function() {
    renderSchoolSearchList();
    document.getElementById('searchSchoolInput').addEventListener('input', renderSchoolSearchList);
});