<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">Daftar Sekolah</h5>
                <div class="ms-auto">
                    <a href="<?= base_url('admin/sekolah/tambah') ?>" class="btn btn-primary d-flex align-items-center">
                        <i class="fa-solid fa-plus me-2"></i> Tambah Data
                    </a>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Search & Filter -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa-solid fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Cari nama sekolah atau alamat..." style="box-shadow: none;">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select id="filterJenjang" class="form-select">
                            <option value="">Semua Jenjang</option>
                            <option value="SD">SD</option>
                            <option value="SMP">SMP</option>
                            <option value="TK">TK</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterKategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Negeri">Negeri</option>
                            <option value="Swasta">Swasta</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="sekolahTable">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th width="80">Foto</th>
                                <th>Nama Sekolah</th>
                                <th>Jenjang</th>
                                <th>Kategori</th>
                                <th>Alamat</th>
                                <th class="text-center">Kurikulum</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sekolah)) : ?>
                                <?php $no = 1;
                                foreach ($sekolah as $s) : ?>
                                    <tr>
                                        <td class="text-center text-muted"><?= $no++ ?></td>
                                        <td>
                                            <?php if ($s['foto']) : ?>
                                                <img src="<?= base_url('uploads/sekolah/' . $s['foto']) ?>" alt="Foto" class="rounded shadow-sm" width="60" height="45" style="object-fit: cover;">
                                            <?php else : ?>
                                                <div class="img-thumb-placeholder">
                                                    <i class="fa-solid fa-school text-secondary opacity-25"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $s['nama_sekolah'] ?></div>
                                            <div class="text-muted small">Lat: <?= $s['latitude'] ?>, Lng: <?= $s['longitude'] ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $s['jenjang'] == 'SD' ? 'bg-danger-subtle text-danger' : ($s['jenjang'] == 'SMP' ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info') ?> border px-2 py-1">
                                                <?= $s['jenjang'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge <?= $s['kategori'] == 'Negeri' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning' ?> border px-2 py-1 text-capitalize">
                                                <?= $s['kategori'] == 'Negeri' ? 'Negeri' : ($s['kategori'] == 'Swasta' ? 'Swasta' : '-') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 250px;"><?= $s['alamat'] ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold text-dark"><?= $s['kurikulum'] ?? '-' ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <a href="<?= base_url('admin/sekolah/edit/' . $s['id_sekolah']) ?>" class="btn btn-sm btn-white text-primary border" title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="<?= base_url('admin/sekolah/hapus/' . $s['id_sekolah']) ?>" class="btn btn-sm btn-white text-danger border" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa-solid fa-folder-open fs-1 opacity-25 mb-3 d-block"></i>
                                            Belum ada data sekolah yang tersimpan.
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Info hasil pencarian -->
                <div id="searchInfo" class="small text-muted mt-2 d-none">
                    <i class="fa-solid fa-filter me-1"></i>
                    Menampilkan <span id="visibleCount">0</span> dari <span id="totalCount">0</span> data
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-white {
        background: #fff;
    }

    .btn-white:hover {
        background: #f8fafc;
    }

    .table th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .img-thumb-placeholder {
        width: 60px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        border-radius: 0.375rem;
    }

    #searchInput:focus,
    #filterJenjang:focus,
    #filterKategori:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.15);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterJenjang = document.getElementById('filterJenjang');
        const filterKategori = document.getElementById('filterKategori');
        const table = document.getElementById('sekolahTable');
        const rows = table.querySelectorAll('tbody tr');
        const searchInfo = document.getElementById('searchInfo');
        const visibleCount = document.getElementById('visibleCount');
        const totalCount = document.getElementById('totalCount');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const jenjangFilter = filterJenjang.value;
            const kategoriFilter = filterKategori.value;
            let visible = 0;
            const total = rows.length;

            rows.forEach(function(row) {
                // Skip the "no data" row
                if (row.querySelector('td[colspan]')) return;

                const nama = (row.cells[2]?.querySelector('.fw-bold')?.textContent || '').toLowerCase();
                const alamat = (row.cells[5]?.querySelector('.text-truncate')?.textContent || row.cells[5]?.textContent || '').toLowerCase();
                const jenjang = (row.cells[3]?.textContent || '').trim();
                const kategori = (row.cells[4]?.textContent || '').trim();

                const matchSearch = searchTerm === '' || nama.includes(searchTerm) || alamat.includes(searchTerm);
                const matchJenjang = jenjangFilter === '' || jenjang === jenjangFilter;
                const matchKategori = kategoriFilter === '' || kategori === kategoriFilter;

                if (matchSearch && matchJenjang && matchKategori) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            totalCount.textContent = total;
            visibleCount.textContent = visible;

            if (searchTerm || jenjangFilter || kategoriFilter) {
                searchInfo.classList.remove('d-none');
            } else {
                searchInfo.classList.add('d-none');
            }

            // Tampilkan pesan jika tidak ada hasil
            let noResultRow = table.querySelector('#noResultRow');
            if (visible === 0 && total > 0) {
                if (!noResultRow) {
                    noResultRow = document.createElement('tr');
                    noResultRow.id = 'noResultRow';
                    noResultRow.innerHTML = `
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="fa-solid fa-search fs-1 opacity-25 mb-3 d-block"></i>
                            Tidak ada data yang sesuai dengan pencarian.
                        </div>
                    </td>
                `;
                    table.querySelector('tbody').appendChild(noResultRow);
                }
                noResultRow.style.display = '';
            } else {
                if (noResultRow) noResultRow.style.display = 'none';
            }
        }

        searchInput.addEventListener('keyup', filterTable);
        filterJenjang.addEventListener('change', filterTable);
        filterKategori.addEventListener('change', filterTable);
    });
</script>
<?= $this->endSection() ?>