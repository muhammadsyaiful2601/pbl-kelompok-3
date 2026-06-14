<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-user-plus text-primary me-2"></i>Form Tambah Admin Baru</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                        <ul class="mb-0 small">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('superadmin/admin/simpan') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label small fw-bold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required placeholder="Masukkan username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= old('nama_lengkap') ?>" required placeholder="Masukkan nama lengkap">
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url('superadmin/admin') ?>" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
