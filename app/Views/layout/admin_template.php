<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= base_url('css/admin_template.css') ?>" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 sidebar d-flex flex-column justify-content-between">

                <!-- Header BKPSDM + Foto Profil -->
                <div class="d-flex justify-content-between align-items-center px-3 mb-3">
                    <div>
                        <div style="font-weight:800;color:#111827;">BKPSDM</div>
                        <div style="font-size:12px;color:var(--muted)">Kab. Bandung Barat</div>
                    </div>
                    <div>
                        <?php
                        $admin = session()->get('user');
                        $foto = $admin['foto'] ?? '';
                        $fotoPath = ROOTPATH . 'public/uploads/' . $foto;
                        ?>
                        <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                            <img src="<?= base_url('uploads/' . $foto) ?>?v=<?= time() ?>" class="rounded-circle" width="40"
                                height="40" alt="Foto Profil">
                        <?php else: ?>
                            <i class="bi bi-person-circle" style="font-size:1.5rem;color:#6c757d;"></i>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Menu Sidebar -->
                <div class="menu mt-3 px-2">
                    <a href="/admin/dashboard" class="<?= (url_is('admin/dashboard')) ? 'active' : '' ?>">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a href="/admin/pengajuanDaftar" class="<?= (url_is('admin/pengajuanDaftar')) ? 'active' : '' ?>">
                        <i class="bi bi-list-check"></i> Daftar Pengajuan
                    </a>
                    <a href="/admin/pengajuanKelola" class="<?= (url_is('admin/pengajuanKelola')) ? 'active' : '' ?>">
                        <i class="bi bi-pencil-square"></i> Kelola Pengajuan
                    </a>
                    <a href="/admin/profil" class="<?= (url_is('admin/profil')) ? 'active' : '' ?>">
                        <i class="bi bi-person-circle"></i> Profil
                    </a>
                    <a href="/admin/dataakundinas" class="<?= (url_is('admin/dataakundinas*')) ? 'active' : '' ?>">
                        <i class="bi bi-building"></i> Data Akun Dinas
                    </a>
                    <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>

            </div>

            <!-- Main Content -->
            <div class="col-md-10 content">
                <?= $this->renderSection('content') ?>
            </div>

        </div>
    </div>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 20px;">
                <div class="modal-body text-center p-5">
                    <div class="mb-3">
                        <i class="bi bi-box-arrow-right text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color:#1f2937;">Konfirmasi Logout</h4>
                    <p class="text-muted mb-4">Apakah Anda yakin ingin keluar dari sistem?<br>
                        Pastikan semua pekerjaan sudah tersimpan.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-pill" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <a href="/logout" class="btn btn-danger px-4 py-2 rounded-pill shadow">
                            <i class="bi bi-check-circle"></i> Ya, Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>