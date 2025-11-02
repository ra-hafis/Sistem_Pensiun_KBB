<?= $this->extend('layout/dinas_template') ?>
<?= $this->section('content') ?>

<div class="card border-0 shadow-sm p-4 rounded-3">
    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
        <img src="/images/kbb.png" alt="Logo" style="height:40px; margin-right:12px;">
        <h3 class="mb-0 text-primary fw-semibold">
            <?= isset($isEdit) && $isEdit ? 'Edit Dokumen Pengajuan' : 'Formulir Pengajuan Baru' ?>
        </h3>
    </div>

    <form action="<?= isset($isEdit) && $isEdit
        ? site_url('dinas/pengajuan/update/' . $pengajuan['id'])
        : site_url('dinas/pengajuan/simpan') ?>" method="post" enctype="multipart/form-data" class="row g-3"
        id="formPengajuan">

        <!-- Nama Pegawai -->
        <div class="col-md-6">
            <label for="nama_pegawai" class="form-label fw-medium">Nama Pegawai <span
                    class="text-danger">*</span></label>
            <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control"
                value="<?= esc($pengajuan['nama_pegawai'] ?? '') ?>" placeholder="Masukkan nama pegawai" required>
        </div>

        <!-- NIP -->
        <div class="col-md-6">
            <label for="nip" class="form-label fw-medium">NIP <span class="text-danger">*</span></label>
            <input type="text" name="nip" id="nip" class="form-control" value="<?= esc($pengajuan['nip'] ?? '') ?>"
                placeholder="Masukkan NIP pegawai" required>
        </div>

        <!-- Golongan -->
        <div class="col-md-6">
            <label for="golongan" class="form-label fw-medium">Golongan <span class="text-danger">*</span></label>
            <input type="text" name="golongan" id="golongan" class="form-control"
                value="<?= esc($pengajuan['golongan'] ?? '') ?>" placeholder="Masukkan golongan pegawai" required>
        </div>

        <!-- Jabatan -->
        <div class="col-md-6">
            <label for="jabatan" class="form-label fw-medium">Jabatan <span class="text-danger">*</span></label>
            <input type="text" name="jabatan" id="jabatan" class="form-control"
                value="<?= esc($pengajuan['jabatan'] ?? '') ?>" placeholder="Masukkan jabatan pegawai" required>
        </div>

        <!-- Tanggal Lahir -->
        <div class="col-md-6">
            <label for="tanggal_lahir" class="form-label fw-medium">Tanggal Lahir <span
                    class="text-danger">*</span></label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                value="<?= esc($pengajuan['tanggal_lahir'] ?? '') ?>" required>
        </div>

        <!-- Dinas (readonly) -->
        <div class="col-md-6">
            <label for="dinas" class="form-label fw-medium">Perangkat Daerah <span class="text-danger">*</span></label>
            <input type="text" id="dinas" class="form-control" value="<?= esc($dinas['nama_dinas'] ?? '') ?>" readonly>
            <input type="hidden" name="dinas_id" value="<?= esc($dinas['id'] ?? '') ?>">
        </div>

        <!-- Jenis Pengajuan -->
        <div class="col-md-6">
            <label for="jenis" class="form-label fw-medium">Jenis Pengajuan <span class="text-danger">*</span></label>
            <select name="jenis" id="jenis" class="form-select" required>
                <?php foreach ($dokumen_per_jenis as $jenis => $dok_list): ?>
                    <option value="<?= esc($jenis) ?>" <?= isset($pengajuan) && $pengajuan['jenis'] === $jenis ? 'selected' : '' ?>>
                        <?= esc($jenis) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Dokumen Upload -->
        <div class="col-md-12 mt-4">
            <h5 class="fw-semibold mb-3 text-primary">Unggah Dokumen Persyaratan</h5>

            <?php
            $jenisDipilih = $pengajuan['jenis'] ?? 'BUP';
            $daftarDokumen = $dokumen_per_jenis[$jenisDipilih] ?? [];
            ?>

            <?php foreach ($daftarDokumen as $dok): ?>
                <div class="mb-3">
                    <label class="form-label"><?= esc($dok['nama']) ?>
                        <?= $dok['wajib'] ? '<span class="text-danger">*</span>' : '' ?>
                    </label>

                    <?php
                    $fileLama = null;
                    if (!empty($dokumen)) {
                        foreach ($dokumen as $d) {
                            if (stripos($d['nama_dokumen'], $dok['nama']) !== false) {
                                $fileLama = $d['file_path'];
                                break;
                            }
                        }
                    }
                    ?>

                    <?php if ($fileLama): ?>
                        <p class="small mb-1">File saat ini:
                            <a href="<?= base_url($fileLama) ?>" target="_blank" class="text-decoration-underline">Lihat</a>
                        </p>
                    <?php endif; ?>

                    <input type="file" name="dokumen_file[]" class="form-control file-upload" accept="application/pdf"
                        <?= $dok['wajib'] ? 'required' : '' ?>>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Aksi -->
        <div class="col-12 text-end mt-3">
            <?php if (isset($isEdit) && $isEdit): ?>
                <a href="<?= site_url('dinas/pengajuan/detail/' . $pengajuan['id']) ?>" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-send"></i> Kirim Pengajuan
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
    window.dokumenPerJenis = <?= json_encode($dokumen_per_jenis, JSON_UNESCAPED_UNICODE) ?>;
</script>

<script src="<?= base_url('js/pengajuan.js') ?>"></script>

<!-- 🔒 Tambahan validasi ukuran file max 2MB -->
<script>
    document.getElementById('formPengajuan').addEventListener('submit', function (e) {
        const files = document.querySelectorAll('.file-upload');
        let valid = true;

        files.forEach(fileInput => {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                if (file.size > 2 * 1024 * 1024) { // 2MB = 2 x 1024 x 1024
                    alert(`File "${file.name}" melebihi ukuran maksimal 2 MB.`);
                    valid = false;
                }
            }
        });

        if (!valid) {
            e.preventDefault(); // hentikan submit
        }
    });
</script>

<?= $this->endSection() ?>