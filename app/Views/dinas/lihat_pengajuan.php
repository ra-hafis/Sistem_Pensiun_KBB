<?= $this->extend('layout/dinas_template') ?>
<?= $this->section('content') ?>

<!--Bootstrap Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<div class="container my-5">

    <div class="card border-0 shadow-lg rounded-4 animate__animated animate__fadeInUp">
        <!-- Card Header -->
        <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
            <i class="bi bi-folder2-open me-2 fs-4"></i>
            <h4 class="mb-0 fw-bold">Pengajuan Saya</h4>
        </div>

        <div class="card-body p-4">

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown"
                    role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('message') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown"
                    role="alert">
                    <i class="bi bi-x-circle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Table -->
            <div class="table-responsive animate__animated animate__fadeInUp animate__delay-1s">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark text-white">
                        <tr class="text-center">
                            <th>#</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan</th>
                            <th>Golongan</th>
                            <th>Dinas</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pengajuan)): ?>
                            <?php foreach ($pengajuan as $idx => $p): ?>
                                <tr
                                    class="align-middle animate__animated animate__fadeInUp animate__delay-<?= ($idx + 1) / 5 ?>s">
                                    <td class="text-center fw-bold"><?= $idx + 1 ?></td>
                                    <td><?= esc($p['nip'] ?? '-') ?></td>
                                    <td><?= esc($p['nama_pegawai'] ?? '-') ?></td>
                                    <td><?= esc($p['jabatan'] ?? '-') ?></td>
                                    <td><?= esc($p['golongan'] ?? '-') ?></td>
                                    <td><?= esc($p['nama_dinas'] ?? '-') ?></td>
                                    <td><?= esc($p['jenis'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $statusColors = [
                                            'Menunggu BKPSDM' => 'bg-warning text-dark',
                                            'Disetujui' => 'bg-success text-white',
                                            'Ditolak' => 'bg-danger text-white'
                                        ];
                                        $statusClass = $statusColors[$p['status']] ?? 'bg-secondary text-white';
                                        ?>
                                        <span
                                            class="badge rounded-pill px-2 py-1 animate__animated animate__pulse animate__infinite <?= $statusClass ?>">
                                            <?= esc($p['status'] ?? '-') ?>
                                        </span>
                                    </td>
                                    <td><?= !empty($p['created_at']) ? date('d-m-Y', strtotime($p['created_at'])) : '-' ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('dinas/pengajuan/detail/' . $p['id']) ?>"
                                            class="btn btn-sm btn-primary rounded-pill shadow-sm px-3 animate__animated animate__fadeInUp">
                                            <i class="bi bi-eye-fill me-1"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4 animate__animated animate__fadeIn">
                                    <i class="bi bi-inbox-fill me-1"></i> Belum ada pengajuan
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tambah Pengajuan Button -->
            <div class="text-end mt-4">
                <a href="<?= base_url('dinas/pengajuan/tambah') ?>"
                    class="btn btn-success btn-lg rounded-pill shadow-lg animate__animated animate__bounce animate__infinite">
                    <i class="bi bi-plus-circle me-1"></i> Pengajuan Baru
                </a>
            </div>

        </div>
    </div>

</div>

<!-- Tambahan CSS khusus untuk gradient -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #003366, #0055A5);
    }

    .table-hover tbody tr:hover {
        background-color: #e9f1ff;
        transform: scale(1.02);
        transition: all 0.3s ease;
    }

    .btn-lg:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
</style>

<?= $this->endSection() ?>