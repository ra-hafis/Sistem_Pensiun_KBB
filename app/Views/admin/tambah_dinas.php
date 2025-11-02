<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Tambah Dinas" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Tambah Akun Dinas</h3>
</div>

<!-- ✅ Tambahan Notifikasi -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<!-- ✅ Akhir Notifikasi -->

<form action="<?= base_url('admin/tambahdinas/simpan') ?>" method="post" class="bg-white p-4 rounded shadow">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="nama_dinas" class="form-label">Nama Dinas</label>
        <input type="text" name="nama_dinas" id="nama_dinas" class="form-control" value="<?= old('nama_dinas') ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= old('username') ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/dataakundinas') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>