<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pengajuan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('css/detail_pengajuan.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="container">

        <!-- Tombol Kembali -->
        <a href="<?= base_url('admin/pengajuanKelola') ?>" class="back-btn">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>

        <!-- Informasi Pegawai -->
        <div class="card">
            <div class="card-header">Informasi Pegawai</div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Nama</th>
                        <td><?= esc($pengajuan['nama_pegawai'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td><?= esc($pengajuan['nip'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Golongan</th>
                        <td><?= esc($pengajuan['golongan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td><?= esc($pengajuan['jabatan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td><?= !empty($pengajuan['tanggal_lahir']) ? date('d F Y', strtotime($pengajuan['tanggal_lahir'])) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Perangkat Daerah</th>
                        <td><?= esc($pengajuan['nama_dinas'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Pengajuan</th>
                        <td><?= esc($pengajuan['jenis'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= esc($pengajuan['status'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td><?= date('d-m-Y H:i', strtotime($pengajuan['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="card">
            <div class="action-buttons">
                <!-- Tombol Tolak dengan Prompt Alasan -->
                <a href="<?= base_url('admin/pengajuanKelola/updateStatus/' . $pengajuan['id'] . '/Ditolak') ?>"
                    class="reject btn btn-danger">
                    ✖ Tolak
                </a>

                <!-- Tombol Setujui -->
                <a href="<?= base_url('admin/pengajuanKelola/updateStatus/' . $pengajuan['id'] . '/Disetujui') ?>"
                    class="approve btn btn-success"
                    onclick="return confirm('Apakah Anda yakin menyetujui pengajuan ini?')">
                    ✔ Setujui
                </a>

                <!-- Tombol Menunggu -->
                <a href="<?= base_url('admin/pengajuanKelola/updateStatus/' . $pengajuan['id'] . '/Menunggu BKPSDM') ?>"
                    class="pending btn btn-warning"
                    onclick="return confirm('Apakah Anda yakin mengubah status menjadi Menunggu BKPSDM?')">
                    ⏳ Menunggu
                </a>
            </div>
        </div>
        <!-- Dokumen yang Diupload -->
        <div class="card">
            <div class="card-header">Berkas yang Diupload</div>
            <div class="doc-grid">
                <?php if (!empty($dokumen)): ?>
                    <?php foreach ($dokumen as $doc): ?>
                        <div class="doc-card">
                            <i class="fas fa-file-alt"></i>
                            <div class="doc-title"><?= esc($doc['nama_dokumen']) ?></div>

                            <?php if ($doc['wajib']): ?>
                                <span class="required">*wajib</span>
                            <?php endif; ?>

                            <?php
                            $ext = strtolower(pathinfo($doc['file_path'], PATHINFO_EXTENSION));
                            $isPreviewable = in_array($ext, ['pdf']);
                            $fileUrl = base_url($doc['file_path']);
                            $filename = basename($doc['file_path']);
                            $downloadUrl = base_url('admin/pengajuanFile/download/' . $filename);
                            ?>
                            <?php if ($isPreviewable): ?>
                                <a href="<?= $fileUrl ?>" target="_blank" class="btn-preview">
                                    Lihat Preview
                                </a>
                            <?php endif; ?>
                            <a href="<?= $downloadUrl ?>" class="btn-download">
                                Download
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Belum ada dokumen diupload</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- Script Tombol Tolak -->
    <script>
        document.querySelector('.reject').addEventListener('click', function (e) {
            e.preventDefault();
            let alasan = prompt("Masukkan alasan penolakan:");
            if (alasan) {
                // redirect ke controller update dengan parameter keterangan
                window.location.href = this.href + '?alasan_penolakan=' + encodeURIComponent(alasan);
            }
        });
    </script>

</body>

</html>