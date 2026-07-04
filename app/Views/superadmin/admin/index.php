<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-end">
            <a href="<?= base_url('superadmin/admin/tambah') ?>" class="btn btn-primary rounded-pill px-4">
                <i class="fa-solid fa-plus me-2"></i>Tambah Admin
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-0 px-4">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-users-gear text-primary me-2"></i>Daftar Administrator</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Role</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($admins as $admin) : ?>
                                <tr class="py-4">
                                    <td class="ps-3"><?= $no++ ?></td>
                                    <td><span class="text-dark"><?= $admin['username'] ?></span></td>
                                    <td><?= $admin['nama_lengkap'] ?? '-' ?></td>
                                    <td><span class="badge rounded-pill" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">Admin</span></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('superadmin/admin/hapus/' . $admin['id_user']) ?>"
                                            class="text-danger text-decoration-none"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?')"
                                            title="Hapus Admin">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($admins)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada admin yang terdaftar.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>