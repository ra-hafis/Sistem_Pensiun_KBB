<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Daftar Pengajuan" style="height:40px; margin-right:12px;">
    <h3 class="mb-0">Daftar Pengajuan</h3>
</div>

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
            <option value="Pemberhentian Karena Tewas">Pemberhentian Karena Tewas</option>
            <option value="Pemberhentian PPPK karena Masa Kerja Berakhir">Pemberhentian PPPK karena Masa Kerja Berakhir
            </option>
            <option value="Pemberhentian PPPK karena Meninggal Dunia">Pemberhentian PPPK karena Meninggal Dunia</option>
            <option value="uzur">Uzur</option>
        </select>
    </div>
    <div class="col-md-4">
        <select id="filterDinas" class="form-select">
            <option value="">Nama Perangkat Daerah</option>
            <?php foreach ($dinasList as $dinas): ?>
                <option value="<?= esc($dinas['nama_dinas']) ?>">
                    <?= esc($dinas['nama_dinas']) ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-x-auto p-3">
    <table class="table table-hover table-bordered" id="pengajuanTable">
        <thead class="table-light">
            <tr class="text-center align-middle">
                <th>No</th>
                <th>NIP</th>
                <th>Nama Pegawai</th>
                <th>Jabatan</th>
                <th>Golongan</th>
                <th>Jenis Pengajuan</th>
                <th>Perangkat Daerah</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Hapus Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pengajuan as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nip'] ?? '-') ?></td>
                    <td><?= esc($row['nama_pegawai'] ?? '-') ?></td>
                    <td><?= esc($row['jabatan'] ?? '-') ?></td>
                    <td><?= esc($row['golongan'] ?? '-') ?></td>
                    <td><?= esc($row['jenis'] ?? '-') ?></td>
                    <td><?= esc($row['nama_dinas'] ?? '-') ?></td>
                    <td><?= !empty($row['created_at'])
                        ? date('d-m-Y H:i', strtotime($row['created_at']))
                        : '-' ?>
                    </td>
                    <td class="fw-semibold text-center 
                        <?= ($row['status'] ?? '') == 'Disetujui' ? 'text-success' :
                            (($row['status'] ?? '') == 'Menunggu BKPSDM' ? 'text-warning' : 'text-danger') ?>">
                        <?= esc($row['status'] ?? '-') ?>
                    </td>
                    <td class="text-center">

                        <!-- Tombol Hapus -->
                        <button class="btn btn-sm btn-danger btn-hapus" data-id="<?= $row['id'] ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<!-- Include JS eksternal -->
<script>
    const base_url = "<?= base_url() ?>";
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/daftar_pengajuan.js') ?>"></script>

<?= $this->endSection() ?>