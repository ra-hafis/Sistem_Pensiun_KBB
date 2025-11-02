<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Kelola Pengajuan" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Kelola Pengajuan</h3>
</div>

<!-- Search & Filter -->
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari nama / jenis / dinas...">
    </div>
    <div class="col-md-4">
        <select id="filterJenis" class="form-select">
            <option value="">Semua Jenis Pengajuan</option>
            <option value="bup">Batas Usia Pensiun (BUP)</option>
            <option value="aps">Atas Permintaan Sendiri (APS)</option>
            <option value="meninggal dunia aktif">Meninggal Dunia Aktif</option>
            <option value="uzur">Uzur</option>
            <option value="Pemberhentian Karena Tewas">Pemberhentian Karena Tewas</option>
            <option value="Pemberhentian PPPK karena Masa Kerja Berakhir">Pemberhentian PPPK karena Masa Kerja Berakhir
            </option>
            <option value="Pemberhentian PPPK karena Meninggal Dunia">Pemberhentian PPPK karena Meninggal Dunia</option>
        </select>
    </div>
    <div class="col-md-4">
        <select id="filterDinas" class="form-select">
            <option value="">Semua Dinas / Badan</option>
            <?php foreach ($dinasList as $dinas): ?>
                <option value="<?= esc($dinas['nama_dinas']) ?>">
                    <?= esc($dinas['nama_dinas']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="table-responsive bg-white p-3 rounded shadow">
    <table class="table table-bordered" id="pengajuanTable">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Golongan</th>
                <th>Jabatan</th>
                <th>Jenis</th>
                <th>Perangkat Daerah</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pengajuan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nip'] ?? '-') ?></td>
                    <td><?= esc($row['nama_pegawai'] ?? '-') ?></td>
                    <td><?= esc($row['golongan'] ?? '-') ?></td>
                    <td><?= esc($row['jabatan'] ?? '-') ?></td>
                    <td><?= esc($row['jenis'] ?? '-') ?></td>
                    <td><?= esc($row['nama_dinas'] ?? '-') ?></td>
                    <td>
                        <?php if (($row['status'] ?? '') == 'Menunggu BKPSDM'): ?>
                            <span class="badge bg-warning text-dark"><?= esc($row['status']) ?></span>
                        <?php elseif (($row['status'] ?? '') == 'Disetujui'): ?>
                            <span class="badge bg-success"><?= esc($row['status']) ?></span>
                        <?php elseif (($row['status'] ?? '') == 'Ditolak'): ?>
                            <span class="badge bg-danger"><?= esc($row['status']) ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/pengajuanDetail/' . $row['id']) ?>"
                            class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- SweetAlert Feedback -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->getFlashdata('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Ditolak',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    </script>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?= session()->getFlashdata('success') ?>'
        });
    </script>
<?php endif; ?>

<script>
    const searchInput = document.getElementById("searchInput");
    const filterJenis = document.getElementById("filterJenis");
    const filterDinas = document.getElementById("filterDinas");
    const table = document.getElementById("pengajuanTable");
    const rows = table.getElementsByTagName("tr");

    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const jenisValue = filterJenis.value.toLowerCase();
        const dinasValue = filterDinas.value.toLowerCase();

        for (let i = 1; i < rows.length; i++) {
            let cols = rows[i].getElementsByTagName("td");
            if (!cols.length) continue;

            let nama = cols[2].innerText.toLowerCase();
            let jenis = cols[5].innerText.toLowerCase();
            let dinas = cols[6].innerText.toLowerCase();

            let searchMatch =
                nama.includes(searchValue) ||
                jenis.includes(searchValue) ||
                dinas.includes(searchValue);

            let jenisMatch = jenisValue === "" || jenis.includes(jenisValue);
            let dinasMatch = dinasValue === "" || dinas.includes(dinasValue);

            rows[i].style.display = (searchMatch && jenisMatch && dinasMatch) ? "" : "none";
        }
    }

    searchInput.addEventListener("keyup", filterTable);
    filterJenis.addEventListener("change", filterTable);
    filterDinas.addEventListener("change", filterTable);
</script>

<?= $this->endSection() ?>