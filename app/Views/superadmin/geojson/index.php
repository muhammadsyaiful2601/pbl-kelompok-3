<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-layer-group text-primary me-2"></i>Daftar GeoJSON</h6>
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

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkAll">
                        <label class="form-check-label fw-semibold" for="checkAll">Pilih Semua</label>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <a href="<?= base_url('superadmin/geojson/clean') ?>" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Bersihkan Nama">
                            <i class="fa-solid fa-broom"></i>
                        </a>
                        <a href="<?= base_url('superadmin/geojson/scan') ?>" class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Pindai File">
                            <i class="fa-solid fa-magnifying-glass-location"></i>
                        </a>
                        <button type="button" class="btn btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" id="btnHapusMultiple" disabled title="Hapus yang Dipilih">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>

                <form id="formHapusMultiple" action="<?= base_url('superadmin/geojson/hapus-multiple') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle border-light" style="border-bottom: 1px solid #f1f5f9;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" style="width: 40px;">&nbsp;</th>
                                    <th>No</th>
                                    <th>Nama Wilayah/Layer</th>
                                    <th class="text-center">Warna</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($geojsons as $gj) : ?>
                                    <tr class="border-bottom border-light">
                                        <td class="ps-3">
                                            <input type="checkbox" class="form-check-input check-row" name="ids[]" value="<?= $gj['id_geojson'] ?>">
                                        </td>
                                        <td class="ps-0"><?= $no++ ?></td>
                                        <td><span class="text-capitalize" style="font-weight: 500;"><?= $gj['nama_geojson'] ?></span></td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="rounded-circle me-2" style="width: 16px; height: 16px; background-color: <?= $gj['warna_geojson'] ?>; opacity: 0.9;"></div>
                                                <span class="small text-muted"><?= strtoupper($gj['warna_geojson']) ?></span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-3">
                                                <a href="<?= base_url('superadmin/geojson/toggle/' . $gj['id_geojson']) ?>" class="text-secondary text-decoration-none" title="<?= $gj['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                                    <i class="fa-solid <?= $gj['is_active'] ? 'fa-eye' : 'fa-eye-slash' ?>"></i>
                                                </a>
                                                <a href="<?= base_url('superadmin/geojson/edit/' . $gj['id_geojson']) ?>" class="text-primary text-decoration-none" title="Atur Gaya Visual">
                                                    <i class="fa-solid fa-palette"></i>
                                                </a>
                                                <a href="<?= base_url('superadmin/geojson/hapus/' . $gj['id_geojson']) ?>" class="text-danger text-decoration-none" onclick="return confirm('Hapus data ini dari sistem?')" title="Hapus">
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
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const checkRows = document.querySelectorAll('.check-row');
        const btnHapusMultiple = document.getElementById('btnHapusMultiple');
        const formHapusMultiple = document.getElementById('formHapusMultiple');

        function updateCheckAllState() {
            const total = checkRows.length;
            const checked = document.querySelectorAll('.check-row:checked').length;
            checkAll.checked = total > 0 && checked === total;
            checkAll.indeterminate = checked > 0 && checked < total;
            btnHapusMultiple.disabled = checked === 0;
        }

        checkAll.addEventListener('change', function() {
            checkRows.forEach(function(row) {
                row.checked = checkAll.checked;
            });
            updateCheckAllState();
        });

        checkRows.forEach(function(row) {
            row.addEventListener('change', updateCheckAllState);
        });

        btnHapusMultiple.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.check-row:checked');
            if (checkedBoxes.length > 0) {
                if (confirm('Hapus ' + checkedBoxes.length + ' data GeoJSON yang dipilih dari sistem?')) {
                    formHapusMultiple.submit();
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>