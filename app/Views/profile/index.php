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
                        <?php if ($avatar) : ?>
                            <img src="<?= base_url('uploads/user/' . $avatar) ?>" class="rounded-circle shadow-sm" alt="Foto Profil" style="width: 140px; height: 140px; object-fit: cover;">
                        <?php else : ?>
                            <div class="rounded-circle shadow-sm mx-auto" style="width: 140px; height: 140px; background: #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-user text-secondary opacity-25" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <input type="hidden" name="foto_lama" value="<?= old('foto_lama', $user['foto'] ?? '') ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label small fw-bold">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $user['username'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $user['nama_lengkap'] ?? '') ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small fw-bold">Password Baru <span class="text-muted small">(kosongkan jika tidak ingin mengganti)</span></label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru">
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label small fw-bold">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <input type="hidden" name="foto_base64" id="foto_base64">
                        <p class="text-muted x-small mt-2 mb-0">Format: JPG, JPEG, PNG (Maks. 10MB)</p>
                        <div id="foto-warning-profile" class="alert alert-warning py-2 mt-2 mb-0 small d-none" style="border-radius: 8px;"></div>
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

<script>
    /**
     * Memproses kompresi gambar client-side menggunakan HTML5 Canvas.
     */
    function compressImage(fileInput, maxWidth = 1000, maxHeight = 1000, quality = 0.8) {
        return new Promise((resolve) => {
            if (!fileInput.files || !fileInput.files[0]) {
                resolve(null);
                return;
            }

            const file = fileInput.files[0];
            if (!file.type.startsWith('image/')) {
                resolve(null);
                return;
            }

            if (file.size < 500 * 1024) {
                resolve(null);
                return;
            }

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > maxWidth) {
                            height = Math.round((height * maxWidth) / width);
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width = Math.round((width * maxHeight) / height);
                            height = maxHeight;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob((blob) => {
                        if (!blob) {
                            resolve(null);
                            return;
                        }
                        const compressedFile = new File([blob], file.name.substring(0, file.name.lastIndexOf('.')) + '.jpg', {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
                img.onerror = () => resolve(null);
            };
            reader.onerror = () => resolve(null);
        });
    }

    const fotoInput = document.querySelector('#foto');
    const fotoWarning = document.querySelector('#foto-warning-profile');

    fotoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            if (file.size > 10 * 1024 * 1024) {
                fotoWarning.textContent = 'Ukuran file melebihi 10MB. Silakan pilih file yang lebih kecil.';
                fotoWarning.classList.remove('d-none');
                this.value = '';
            } else {
                fotoWarning.classList.add('d-none');
            }
        }
    });

    document.querySelector('form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Mengompres Foto...';

        try {
            if (fotoInput && fotoInput.files && fotoInput.files[0]) {
                const compressed = await compressImage(fotoInput, 1000, 1000, 0.85);
                if (compressed) {
                    const base64Data = await new Promise((resolve) => {
                        const reader = new FileReader();
                        reader.onloadend = () => resolve(reader.result);
                        reader.readAsDataURL(compressed);
                    });
                    document.getElementById('foto_base64').value = base64Data;
                    fotoInput.value = '';
                }
            }
        } catch (err) {
            console.error('Error compression:', err);
        }

        this.submit();
    });
</script>
<?= $this->endSection() ?>
