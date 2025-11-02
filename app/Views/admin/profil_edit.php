<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Edit Profil BKPSDM" style="height:50px; margin-right:12px;">
    <h3 class="mb-0 fw-bold">Edit Profil BKPSDM</h3>
</div>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4 border-0">
        <h4 class="fw-bold mb-3 text-center text-primary">
            <i class="bi bi-pencil-square"></i> Formulir Edit Profil BKPSDM
        </h4>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/admin/profil/update') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <?php
            $nama     = $admin['nama'] ?? '';
            $username = $admin['username'] ?? '';
            $alamat   = $admin['alamat'] ?? '';
            $whatsapp = $admin['whatsapp'] ?? '';
            $email    = $admin['email'] ?? '';
            $website  = $admin['website'] ?? '';
            $kepala   = $admin['kepala'] ?? '';
            $foto     = $admin['foto'] ?? '';
            $fotoPath = ROOTPATH . 'public/uploads/' . $foto;
            ?>

            <div class="row">
                <!-- Foto -->
                <div class="col-md-4 text-center">
                    <div class="mb-3">
                        <label class="form-label d-block fw-bold">Foto Profil Saat Ini</label>
                        <?php if (!empty($foto) && file_exists($fotoPath)): ?>
                            <img src="<?= base_url('uploads/' . $foto) ?>?v=<?= time() ?>"
                                class="shadow-sm border border-2 border-primary rounded"
                                style="object-fit:cover; width:200px; height:200px;" alt="Foto Profil">
                        <?php else: ?>
                            <i class="bi bi-person-square text-secondary" style="font-size:120px;"></i>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fw-bold"><i class="bi bi-image"></i> Ganti Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                    </div>
                </div>

                <!-- Form Input -->
                <div class="col-md-8">
                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-person-badge"></i> Data Admin</h5>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                   value="<?= esc($nama) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-at"></i></span>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?= esc($username) ?>" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-building"></i> Biodata Instansi</h5>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"><?= esc($alamat) ?></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp" class="form-label">Whatsapp</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" 
                                   value="<?= esc($whatsapp) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= esc($email) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-globe"></i></span>
                            <input type="text" class="form-control" id="website" name="website" 
                                   value="<?= esc($website) ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="kepala" class="form-label">Kepala BKPSDM</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-people"></i></span>
                            <input type="text" class="form-control" id="kepala" name="kepala" 
                                   value="<?= esc($kepala) ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="text-center mt-4">
                <a href="<?= base_url('/admin/profil') ?>" class="btn btn-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-check2-circle"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>
