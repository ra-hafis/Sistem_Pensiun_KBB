<?= $this->extend('layout/dinas_template') ?>
<?= $this->section('content') ?>

<h3 class="mb-4">Selamat Datang,
    <span class="text-primary"><?= esc($user['nama'] ?? $user['nama_dinas'] ?? 'Nama User') ?></span>
</h3>

<div class="row g-4">
    <!-- Card Total Pengajuan -->
    <div class="col-md-6 col-lg-4">
        <div class="card hover-shadow text-center p-4">
            <div class="card-body">
                <i class="bi bi-clipboard-data card-icon text-primary"></i>
                <h5 class="mt-3">Total Pengajuan</h5>
                <h2 class="fw-bold"><?= $totalPengajuan ?? 0 ?></h2>
            </div>
        </div>
    </div>

    <!-- Card Status Terakhir -->
    <div class="col-md-6 col-lg-4">
        <div class="card hover-shadow text-center p-4">
            <div class="card-body">
                <i class="bi bi-clock-history card-icon text-warning"></i>
                <h5 class="mt-3">Status Terakhir</h5>
                <h5 class="fw-semibold">
                    <?= esc($statusTerakhir ?? '-') ?>
                </h5>
            </div>
        </div>
    </div>

    <!-- Card Aksi Cepat -->
    <div class="col-md-6 col-lg-4">
        <div class="card hover-shadow text-center p-4">
            <div class="card-body">
                <i class="bi bi-plus-circle card-icon text-success"></i>
                <h5 class="mt-3">Buat Pengajuan Baru</h5>
                <a href="<?= base_url('dinas/pengajuan/tambah') ?>" class="btn btn-success mt-2">Tambah</a>
            </div>
        </div>
    </div>
</div>

<?php if (isset($showPopup) && $showPopup && strtolower($statusTerakhir) === 'ditolak'): ?>
    <div class="modal fade" id="modalDitolak" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-3">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-x-circle-fill me-2"></i> Pengajuan Ditolak</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Pengajuan terakhir Anda telah <strong>ditolak</strong> oleh admin.</p>
                    <?php if (!empty($alasan_penolakan)): ?>
                        <p><strong>Alasan:</strong> <?= esc($alasan_penolakan) ?></p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-check-circle"></i> Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById('modalDitolak'));
            myModal.show();
        });
    </script>
<?php endif; ?>

<?= $this->endSection() ?>