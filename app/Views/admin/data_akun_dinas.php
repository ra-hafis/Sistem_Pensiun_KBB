<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Data Akun Dinas" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Data Akun Dinas</h3>
</div>

<!-- Tombol Tambah -->
<div class="mb-3 text-end">
    <a href="<?= base_url('admin/tambahdinas') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
        <i class="bi bi-plus-lg"></i> Tambah Akun Dinas
    </a>
</div>

<!-- Search -->
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama dinas / username...">
    </div>
</div>

<div class="table-responsive bg-white p-3 rounded shadow">
    <table class="table table-bordered" id="dinasTable">
        <thead class="table-light text-center">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Dinas</th>
                <th style="width: 25%;">Username</th>
                <th style="width: 25%;">Password</th>
                <th style="width: 15%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dinas as $d): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= esc($d['nama_dinas']) ?></td>
                    <td><?= esc($d['username']) ?></td>
                    <td>
                        <span class="password-mask">••••••••</span>
                        <button type="button" class="btn btn-link btn-sm text-secondary p-0 ms-1 toggle-password"
                            data-password="<?= esc($d['password']) ?>">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="<?= base_url('admin/editdinas/' . $d['id']) ?>"
                                class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <a href="<?= base_url('admin/hapusdinas/' . $d['id']) ?>"
                                class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm"
                                onclick="return confirm('Yakin ingin menghapus akun ini?')">
                                <i class="bi bi-trash"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- SweetAlert Feedback -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>'
        });
    </script>
<?php elseif (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    </script>
<?php endif; ?>

<!-- Script Search & Password Toggle -->
<script>
    const searchInput = document.getElementById("searchInput");
    const rows = document.querySelectorAll("#dinasTable tbody tr");

    searchInput.addEventListener("keyup", () => {
        const value = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const nama = row.cells[1].innerText.toLowerCase();
            const username = row.cells[2].innerText.toLowerCase();
            row.style.display = (nama.includes(value) || username.includes(value)) ? "" : "none";
        });
    });

    document.querySelectorAll(".toggle-password").forEach(btn => {
        btn.addEventListener("click", function () {
            const mask = this.previousElementSibling;
            if (mask.innerText === "••••••••") {
                mask.innerText = this.dataset.password || "(terenkripsi)";
                this.innerHTML = '<i class="bi bi-eye-slash"></i>';
            } else {
                mask.innerText = "••••••••";
                this.innerHTML = '<i class="bi bi-eye"></i>';
            }
        });
    });
</script>

<?= $this->endSection() ?>