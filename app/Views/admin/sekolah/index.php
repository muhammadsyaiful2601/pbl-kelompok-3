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
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th width="80">Foto</th>
                                <th>Nama Sekolah</th>
                                <th>Jenjang</th>
                                <th>Alamat</th>
                                <th class="text-center">Siswa</th>
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
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 60px; height: 45px;">
                                                    <i class="fa-solid fa-image text-muted small"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?= $s['nama_sekolah'] ?></div>
                                            <div class="text-muted small">Lat: <?= $s['latitude'] ?>, Lng: <?= $s['longitude'] ?></div>
                                        </td>
                                        <td>
                                            <span class="badge <?= $s['jenjang'] == 'SD' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' ?> border px-2 py-1">
                                                <?= $s['jenjang'] ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 250px;"><?= $s['alamat'] ?></div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold text-dark"><?= number_format($s['jumlah_siswa'] ?? 0, 0, ',', '.') ?></span>
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
                                    <td colspan="7" class="text-center py-5">
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
</style>
<?= $this->endSection() ?>