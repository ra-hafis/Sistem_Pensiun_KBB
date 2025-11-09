<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Edit Dinas" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Edit Akun Dinas</h3>
</div>

<!-- Notifikasi -->
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertMessage">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/editdinas/update/' . $dinas['id']) ?>" method="post"
    class="bg-white p-4 rounded shadow">
    <div class="mb-3">
        <label for="nama_dinas" class="form-label">Nama Dinas</label>
        <input type="text" name="nama_dinas" id="nama_dinas" class="form-control"
            value="<?= esc($dinas['nama_dinas']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= esc($dinas['username']) ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password (opsional)</label>
        <input type="password" name="password" id="password" class="form-control"
            placeholder="Kosongkan jika tidak ingin mengubah">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="<?= base_url('admin/dataakundinas') ?>" class="btn btn-secondary">Batal</a>
</form>

<!--Script auto-hide notifikasi error setelah 5 detik -->
<script>
    setTimeout(() => {
        const alert = document.getElementById('alertMessage');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 5000);
</script>

<?= $this->endSection() ?>