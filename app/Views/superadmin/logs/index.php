<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">
                    <i class="fa-solid fa-clock-rotate-left text-primary me-2"></i>Log Aktivitas Administrator
                </h6>
                <div class="d-flex gap-2 align-items-center">
                    <span class="badge bg-light text-dark border p-2 rounded-pill">Total Log: <?= count($logs) ?></span>
                    <a href="<?= base_url('superadmin/logs/hapus-semua') ?>" 
                       class="btn btn-sm btn-outline-danger rounded-pill"
                       onclick="return confirm('Hapus SEMUA log aktivitas? Tindakan ini tidak bisa dibatalkan.')">
                        <i class="fa-solid fa-trash me-1"></i>Hapus Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3" style="width: 5%;">No</th>
                                <th style="width: 20%;">Pengguna</th>
                                <th style="width: 12%;">Tindakan</th>
                                <th style="width: 13%;">Objek Data</th>
                                <th>Deskripsi Aktivitas</th>
                                <th style="width: 15%;">Alamat IP</th>
                                <th class="text-end pe-3" style="width: 15%;">Waktu Kejadian</th>
                                <th class="text-center" style="width: 5%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($logs as $log) : ?>
                                <tr>
                                    <td class="ps-3"><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2 bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; border-radius: 50%; font-size: 0.85rem;">
                                                <?= strtoupper(substr($log['username'] ?? 'U', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-0" style="font-size: 0.9rem;"><?= esc($log['username']) ?></div>
                                                <small class="text-muted" style="font-size: 0.75rem;">@<?= esc($log['username']) ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $action = strtolower($log['action']);
                                            $badgeClass = 'bg-secondary';
                                            $icon = 'fa-circle-info';
                                            if ($action === 'tambah') {
                                                $badgeClass = 'bg-success';
                                                $icon = 'fa-circle-plus';
                                            } elseif ($action === 'ubah') {
                                                $badgeClass = 'bg-warning text-dark';
                                                $icon = 'fa-pen-to-square';
                                            } elseif ($action === 'hapus') {
                                                $badgeClass = 'bg-danger';
                                                $icon = 'fa-trash-can';
                                            }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> d-inline-flex align-items-center gap-1 rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            <i class="fa-solid <?= $icon ?>" style="font-size: 0.7rem;"></i>
                                            <?= ucfirst($log['action']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php
                                            $table = strtolower($log['target_table']);
                                            $tableBadge = 'bg-light text-dark border';
                                            $tableIcon = 'fa-table';
                                            
                                            if ($table === 'sekolah') {
                                                $tableBadge = 'bg-info-subtle text-info border border-info-subtle';
                                                $tableIcon = 'fa-school';
                                            } elseif ($table === 'geojson') {
                                                $tableBadge = 'bg-purple-subtle text-purple border border-purple-subtle';
                                                $tableIcon = 'fa-layer-group';
                                            } elseif ($table === 'user') {
                                                $tableBadge = 'bg-primary-subtle text-primary border border-primary-subtle';
                                                $tableIcon = 'fa-user-cog';
                                            }
                                        ?>
                                        <span class="badge <?= $tableBadge ?> d-inline-flex align-items-center gap-1 rounded-pill px-2 py-1" style="font-size: 0.75rem;">
                                            <i class="fa-solid <?= $tableIcon ?>" style="font-size: 0.7rem;"></i>
                                            <?= ucfirst($log['target_table']) ?><?= $log['target_id'] ? " (#{$log['target_id']})" : "" ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark" style="font-size: 0.9rem;"><?= esc($log['description']) ?></span>
                                    </td>
                                    <td>
                                        <span class="font-monospace text-muted" style="font-size: 0.8rem;">
                                            <i class="fa-solid fa-network-wired me-1" style="font-size: 0.75rem;"></i>
                                            <?= esc($log['ip_address']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <div class="text-dark fw-medium" style="font-size: 0.85rem;">
                                            <?= date('d M Y', strtotime($log['created_at'])) ?>
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <?= date('H:i:s', strtotime($log['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('superadmin/logs/hapus/' . $log['id']) ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-circle p-2"
                                           onclick="return confirm('Hapus log ini?')"
                                           title="Hapus Log">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($logs)) : ?>
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fa-2x mb-3 text-secondary d-block"></i>
                                        Belum ada aktivitas yang tercatat dalam sistem.
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
    .bg-info-subtle {
        background-color: rgba(13, 202, 240, 0.15) !important;
    }
    .text-info {
        color: #0dcaf0 !important;
    }
    .border-info-subtle {
        border-color: rgba(13, 202, 240, 0.25) !important;
    }
    
    .bg-purple-subtle {
        background-color: rgba(111, 66, 193, 0.15) !important;
    }
    .text-purple {
        color: #6f42c1 !important;
    }
    .border-purple-subtle {
        border-color: rgba(111, 66, 193, 0.25) !important;
    }
    
    .bg-primary-subtle {
        background-color: rgba(13, 110, 253, 0.15) !important;
    }
    .text-primary {
        color: #0d6efd !important;
    }
    .border-primary-subtle {
        border-color: rgba(13, 110, 253, 0.25) !important;
    }
</style>
<?= $this->endSection() ?>
