<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Dinas' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?= base_url('css/dashboard.css') ?>" rel="stylesheet">
</head>

<body>
    <?php $user = session()->get('user'); ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm bg-white">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= base_url('dinas/dashboard') ?>">
                <img src="/images/kbb.png" alt="Logo BKPSDM" style="height: 50px; margin-right: 10px;">
                <span class="fw-bold">BKPSDM</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('dinas/dashboard') ? 'active' : '' ?>"
                            href="<?= base_url('dinas/dashboard') ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('dinas/pengajuan') ? 'active' : '' ?>"
                            href="<?= base_url('dinas/pengajuan') ?>">
                            <i class="bi bi-file-earmark-text"></i> Pengajuan Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <div class="modal-body text-center p-5">
                    <div class="mb-3">
                        <i class="bi bi-box-arrow-right text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color:#1f2937;">Konfirmasi Logout</h4>
                    <p class="text-muted mb-4">
                        Apakah Anda yakin ingin keluar dari sistem?<br>
                        Pastikan semua pekerjaan sudah tersimpan.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger px-4 py-2 rounded-pill shadow">
                            <i class="bi bi-check-circle"></i> Ya, Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container my-5">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-5 py-4 bg-white shadow-sm">
        <p class="mb-0">&copy; 2025 BKPSDM Kab. Bandung Barat</p>
        <small class="text-muted">Login sebagai: <?= esc($user['nama_dinas'] ?? 'Unit Dinas') ?></small>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>