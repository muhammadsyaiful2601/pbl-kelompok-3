let currentJenjangFilter = 'semua';

/* Fungsi untuk merender daftar sekolah ke elemen HTML berdasarkan filter dan kata kunci */
function renderSchoolSearchList() {
    const listContainer = document.getElementById('schoolSearchList');
    const searchKeyword = document.getElementById('searchSchoolInput').value.toLowerCase();

    if (!listContainer) return;
    listContainer.innerHTML = '';

    const filteredSchools = window.sekolahData.filter(school => {
        const nama = (school.nama_sekolah || school.name || '').toLowerCase();
        const alamat = (school.alamat || school.addr || '').toLowerCase();
        const jenjang = (school.jenjang || school.type || 'SD').toLowerCase();

        const matchesSearch = nama.includes(searchKeyword) || alamat.includes(searchKeyword);
        const matchesJenjang = currentJenjangFilter === 'semua' || jenjang === currentJenjangFilter.toLowerCase();

        return matchesSearch && matchesJenjang;
    });

    if (filteredSchools.length === 0) {
        listContainer.innerHTML = '<div class="text-center text-muted py-4 small">Sekolah tidak ditemukan.</div>';
        return;
    }

    filteredSchools.forEach(school => {
        const nama = school.nama_sekolah || school.name;
        const alamat = school.alamat || school.addr || 'Alamat belum diatur';
        const jenjang = (school.jenjang || school.type || 'SD').toUpperCase();
        const badgeColor = jenjang === 'SD' ? 'bg-success' : 'bg-primary';

        const itemHtml = `
            <div class="school-search-item" onclick="focusToMapMatrix(${school.latitude || school.lat}, ${school.longitude || school.lng}, '${nama}')">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <h6 class="fw-bold mb-0 text-dark small" style="font-size: 0.88rem;">${nama}</h6>
                    <span class="badge ${badgeColor}">${jenjang}</span>
                </div>
                <p class="text-muted mb-0" style="font-size: 0.78rem; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                    <i class="fa-solid fa-map-marker-alt text-danger me-1"></i> ${alamat}
                </p>
            </div>
        `;
        listContainer.insertAdjacentHTML('beforeend', itemHtml);
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
}

/* Fungsi untuk memindahkan fokus tampilan peta koordinat dan menggulir halaman ke area peta */
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