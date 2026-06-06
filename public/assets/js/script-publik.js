// Fungsi untuk memfilter Card
function filterSekolah(jenjang) {
    const items = document.querySelectorAll('.item-sekolah');
    const buttons = document.querySelectorAll('.btn-group .btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    if (window.event && window.event.target) {
        window.event.target.classList.add('active');
    }

    items.forEach(item => {
        if (jenjang === 'semua') {
            item.style.display = 'block';
        } else {
            if (item.getAttribute('data-jenjang').toLowerCase() === jenjang.toLowerCase()) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    // Atur koordinat default
    var map = L.map('preview-map').setView([-0.941, 100.370], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Membaca data dinamis yang di-inject dari file View utama
    var dataSekolah = window.sekolahData || [];

    // Looping data marker otomatis dari database
    dataSekolah.forEach(function(school) {
        var latitude = school.latitude || school.lat;
        var longitude = school.longitude || school.lng;
        var namaSekolah = school.nama_sekolah || school.name;
        var alamatSekolah = school.alamat || school.addr;
        var jenjangSekolah = school.jenjang || school.type || 'SD';

        if (latitude && longitude) {
            var marker = L.marker([latitude, longitude]).addTo(map);
            var badgeColor = jenjangSekolah.toLowerCase() === 'sd' ? 'bg-success' : 'bg-primary';

            marker.bindPopup(`
                <div style="min-width: 160px;">
                    <span class="badge ${badgeColor} mb-1">${jenjangSekolah.toUpperCase()}</span>
                    <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">${namaSekolah}</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-map-marker-alt text-danger me-1"></i> ${alamatSekolah}
                    </p>
                </div>
            `);
        }
    });

    setTimeout(function() {
        map.invalidateSize();
    }, 300);
});