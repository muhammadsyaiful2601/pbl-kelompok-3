<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-user fa-fw text-primary me-2"></i>Profil Saya</h6>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 10px;">
                        <ul class="mb-0 small">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="text-center mb-4">
                        <?php $avatar = $user['foto'] ?? session()->get('foto'); ?>
                        <img src="<?= $avatar ? base_url('uploads/user/' . $avatar) : 'https://via.placeholder.com/140x140?text=Profil' ?>" class="rounded-circle shadow-sm" alt="Foto Profil" style="width: 140px; height: 140px; object-fit: cover;">
                    </div>

                    <input type="hidden" name="foto_lama" value="<?= old('foto_lama', $user['foto'] ?? '') ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label small fw-bold">Username</label>
                        <input type="text" class="form-control" value="<?= $user['username'] ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold">Password Baru <span class="text-muted small">(kosongkan jika tidak ingin mengganti)</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru">
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label small fw-bold">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="<?= base_url(session()->get('role') === 'superadmin' ? 'superadmin/dashboard' : 'admin/dashboard') ?>" class="btn btn-light rounded-pill px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>