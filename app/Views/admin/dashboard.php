<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Dashboard" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Dashboard Admin</h3>
</div>

<!-- Flash Message -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php
$total = $total_pengajuan ?? 0;
$disetujui = $disetujui ?? 0;
$menunggu = $menunggu ?? 0;
$ditolak = $ditolak ?? 0;

$stats = [
    'Minggu' => [
        'Disetujui' => $minggu_disetujui ?? 0,
        'Menunggu BKPSDM' => $minggu_menunggu ?? 0,
        'Ditolak' => $minggu_ditolak ?? 0
    ],
    'Bulan' => [
        'Disetujui' => $bulan_disetujui ?? 0,
        'Menunggu BKPSDM' => $bulan_menunggu ?? 0,
        'Ditolak' => $bulan_ditolak ?? 0
    ],
    'Tahun' => [
        'Disetujui' => $tahun_disetujui ?? 0,
        'Menunggu BKPSDM' => $tahun_menunggu ?? 0,
        'Ditolak' => $tahun_ditolak ?? 0
    ],
];

$totalStats = [];
foreach ($stats as $periode => $data) {
    $totalStats[$periode] = array_sum($data);
}
?>

<!-- Dashboard Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0">
            <h5>Total Pengajuan</h5>
            <p class="fs-3 fw-bold text-primary"><?= $total ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0">
            <h5>Pengajuan Disetujui</h5>
            <p class="fs-3 fw-bold text-success"><?= $disetujui ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0">
            <h5>Menunggu BKPSDM</h5>
            <p class="fs-3 fw-bold text-warning"><?= $menunggu ?></p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0">
            <h5>Ditolak</h5>
            <p class="fs-3 fw-bold text-danger"><?= $ditolak ?></p>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row">
    <?php foreach ($stats as $periode => $data): ?>
        <div class="col-md-4 mb-4">
            <div class="card p-3 shadow-sm border-0">
                <h5 class="mb-3">Pengajuan <?= $periode ?></h5>
                <canvas id="chart-<?= strtolower($periode) ?>"></canvas>
                <div class="mt-3 text-center">
                    <strong>Total <?= $periode ?> ini:</strong> <?= $totalStats[$periode] ?> pengajuan
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Rekap Keseluruhan -->
<div class="card p-3 mt-4 shadow-sm border-0">
    <h5 class="mb-2">Rekap Keseluruhan</h5>
    <p class="mb-1">Minggu ini: <strong><?= $totalStats['Minggu'] ?></strong> pengajuan</p>
    <p class="mb-1">Bulan ini: <strong><?= $totalStats['Bulan'] ?></strong> pengajuan</p>
    <p class="mb-1">Tahun ini: <strong><?= $totalStats['Tahun'] ?></strong> pengajuan</p>
    <hr>
    <p class="fw-bold text-primary">Total keseluruhan: <?= $total ?> pengajuan</p>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    <?php foreach ($stats as $periode => $data): ?>
        const ctx<?= $periode ?> = document.getElementById('chart-<?= strtolower($periode) ?>').getContext('2d');
        new Chart(ctx<?= $periode ?>, {
            type: 'bar',
            data: {
                labels: ['Disetujui', 'Menunggu BKPSDM', 'Ditolak'],
                datasets: [{
                    label: 'Jumlah Pengajuan <?= $periode ?>',
                    data: [<?= $data['Disetujui'] ?>, <?= $data['Menunggu BKPSDM'] ?>, <?= $data['Ditolak'] ?>],
                    backgroundColor: ['#198754', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let value = context.raw;
                                let percentage = total ? ((value / total) * 100).toFixed(1) : 0;
                                return context.label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
    <?php endforeach; ?>
</script>

<?= $this->endSection() ?>