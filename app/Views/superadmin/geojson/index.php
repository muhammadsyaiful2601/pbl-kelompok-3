<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-layer-group text-primary me-2"></i>Daftar GeoJSON</h6>
                <div>
                    <a href="<?= base_url('superadmin/geojson/clean') ?>" class="btn btn-outline-secondary rounded-pill px-4 me-2">
                        <i class="fa-solid fa-broom me-2"></i>Bersihkan Nama
                    </a>
                    <a href="<?= base_url('superadmin/geojson/scan') ?>" class="btn btn-outline-primary rounded-pill px-4 me-2">
                        <i class="fa-solid fa-magnifying-glass-location me-2"></i>Pindai File Lokal
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 10px;">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Wilayah/Layer</th>
                                <th>File Path</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($geojsons as $gj) : ?>
                                <tr>
                                    <td class="ps-3"><?= $no++ ?></td>
                                    <td><span class="fw-bold text-dark text-capitalize"><?= $gj['nama_geojson'] ?></span></td>
                                    <td><code class="small text-muted"><?= $gj['file_geojson'] ?></code></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('superadmin/geojson/toggle/' . $gj['id_geojson']) ?>" 
                                           class="btn btn-sm <?= $gj['is_active'] ? 'btn-success' : 'btn-secondary' ?> rounded-pill px-3">
                                            <?= $gj['is_active'] ? '<i class="fa-solid fa-eye me-1"></i>Aktif' : '<i class="fa-solid fa-eye-slash me-1"></i>Nonaktif' ?>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="<?= base_url('superadmin/geojson/edit/' . $gj['id_geojson']) ?>" 
                                               class="btn btn-sm btn-outline-primary rounded-circle p-2" 
                                               title="Atur Gaya Visual">
                                                <i class="fa-solid fa-palette"></i>
                                            </a>
                                            <a href="<?= base_url('superadmin/geojson/hapus/' . $gj['id_geojson']) ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-circle p-2" 
                                               onclick="return confirm('Hapus data ini dari sistem?')"
                                               title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($geojsons)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-1 opacity-25 mb-3 d-block"></i>
                                        Belum ada data GeoJSON terdaftar. Klik <strong>Pindai File Lokal</strong> untuk mengimpor dari <code>assets/geojson/</code>.
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
<?= $this->endSection() ?>
