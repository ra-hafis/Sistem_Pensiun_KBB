<?= $this->extend('layout/dinas_template') ?>
<?= $this->section('content') ?>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<div class="container my-5">
    <div class="card shadow-lg rounded-5 border-0" style="font-family: 'Inter', sans-serif;">
        <!-- Header -->
        <div class="card-header bg-gradient-primary text-white rounded-top-5 d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-3 fs-4"></i>
            <h4 class="mb-0 fw-bold">Detail Pengajuan</h4>
        </div>

        <div class="card-body p-5 bg-light">

            <?php $fields = [
                ['label' => 'Nama Pegawai', 'icon' => 'person-badge-fill', 'value' => $pengajuan['nama_pegawai']],
                ['label' => 'NIP', 'icon' => '123', 'value' => $pengajuan['nip']],
                ['label' => 'Jabatan', 'icon' => 'person-workspace', 'value' => $pengajuan['jabatan']],
                ['label' => 'Golongan', 'icon' => 'award', 'value' => $pengajuan['golongan']],
                ['label' => 'Tanggal Lahir', 'icon' => 'calendar-heart-fill', 'value' => !empty($pengajuan['tanggal_lahir']) ? date('d F Y', strtotime($pengajuan['tanggal_lahir'])) : '-'],
                ['label' => 'Dinas', 'icon' => 'building', 'value' => $pengajuan['nama_dinas']],
                ['label' => 'Jenis Pengajuan', 'icon' => 'tags-fill', 'value' => $pengajuan['jenis']],
                ['label' => 'Tanggal Pengajuan', 'icon' => 'calendar-event-fill', 'value' => date('d-m-Y', strtotime($pengajuan['created_at']))],
            ]; ?>

            <div class="row g-4">
                <?php foreach ($fields as $f): ?>
                    <div class="col-md-6">
                        <label class="fw-semibold text-secondary d-block mb-1">
                            <i class="bi bi-<?= $f['icon'] ?> text-primary me-2"></i><?= esc($f['label']) ?>
                        </label>
                        <div class="p-3 bg-white rounded-4 shadow-sm fw-medium">
                            <?= esc($f['value']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- Status khusus -->
                <div class="col-md-6">
                    <label class="fw-semibold text-secondary d-block mb-1">
                        <i class="bi bi-flag-fill text-primary me-2"></i>Status
                    </label>
                    <div>
                        <?php if ($pengajuan['status'] == 'Menunggu BKPSDM'): ?>
                            <span class="badge rounded-pill text-dark px-4 py-2"
                                style="background: linear-gradient(135deg, #FFECB3, #FFD54F); font-weight:600;">
                                <i class="bi bi-hourglass-split me-1"></i> <?= esc($pengajuan['status']) ?>
                            </span>
                        <?php elseif ($pengajuan['status'] == 'Disetujui'): ?>
                            <span class="badge rounded-pill text-white px-4 py-2"
                                style="background: linear-gradient(135deg, #81C784, #4CAF50); font-weight:600;">
                                <i class="bi bi-check-circle-fill me-1"></i> <?= esc($pengajuan['status']) ?>
                            </span>
                        <?php elseif ($pengajuan['status'] == 'Ditolak'): ?>
                            <span class="badge rounded-pill text-white px-4 py-2"
                                style="background: linear-gradient(135deg, #E57373, #D32F2F); font-weight:600;">
                                <i class="bi bi-x-circle-fill me-1"></i> <?= esc($pengajuan['status']) ?>
                            </span>
                        <?php else: ?>
                            <span class="badge rounded-pill bg-secondary text-white px-4 py-2">-</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-5 d-flex justify-content-between align-items-center">
                <!-- Tombol Kembali -->
                <a href="<?= base_url('dinas/pengajuan') ?>"
                    class="btn btn-outline-primary rounded-pill px-4 py-2 shadow-sm fw-semibold"
                    style="border-width: 2px; transition: all 0.3s;">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(90deg, #003366, #0055A5);
    }

    .card-body .p-3 {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-body .p-3:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    .btn-outline-primary:hover {
        background: linear-gradient(90deg, #003366, #0055A5);
        color: #fff;
    }
</style>

<?= $this->endSection() ?>