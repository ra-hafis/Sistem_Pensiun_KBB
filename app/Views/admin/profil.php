<?= $this->extend('layout/admin_template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center mb-4">
    <img src="/images/kbb.png" alt="Profil BKPSDM" style="height:50px; margin-right:12px;">
    <h3 class="mb-0">Profil BKPSDM</h3>
</div>

<div class="container mt-4">
    <div class="card shadow-lg p-4 rounded-4 border-0">
        <div class="row">
            <!-- Logo / Foto -->
            <div class="col-md-4 text-center">
                <h4 class="fw-bold mt-3">BKPSDM</h4>
                <h4 class="fw-bold mt-3">Kabupaten Bandung Barat</h4>
                <p class="text-muted">Badan Kepegawaian dan Pengembangan SDM</p>

                <div class="mt-3">
                    <?php $foto = $admin['foto'] ?? ''; ?>
                    <?php if (!empty($foto)): ?>
                        <img src="<?= base_url('uploads/' . $foto) ?>?v=<?= time() ?>"
                            class="shadow-sm border border-2 border-primary"
                            style="object-fit:cover; width: 250px; height:250px;" alt="Foto Profil">
                    <?php else: ?>
                        <i class="bi bi-person-square" style="font-size:120px;color:#6c757d;"></i>
                    <?php endif; ?>
                </div>

                <div class="mt-3 p-3 bg-light rounded shadow-sm text-start">
                    <p><i class="bi bi-person"></i> <strong>Nama Admin:</strong> <?= esc($admin['nama'] ?? '-') ?></p>
                    <p><i class="bi bi-person-badge"></i> <strong>Username:</strong>
                        <?= esc($admin['username'] ?? '-') ?></p>
                </div>
            </div>

            <!-- Biodata Instansi -->
            <div class="col-md-8">
                <h5 class="fw-bold mb-3">Biodata Instansi</h5>
                <table class="table table-borderless">
                    <tr>
                        <td width="180"><i class="bi bi-geo-alt"></i> Alamat</td>
                        <td>: <?= esc($admin['alamat'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-telephone"></i> Whatsapp</td>
                        <td>: <?= esc($admin['whatsapp'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-envelope"></i> Email</td>
                        <td>: <?= esc($admin['email'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-globe"></i> Website</td>
                        <td>: <a href="<?= esc($admin['website'] ?? '#') ?>" target="_blank">
                                <?= esc($admin['website'] ?? '-') ?></a></td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-people"></i> Kepala BKPSDM</td>
                        <td>: <?= esc($admin['kepala'] ?? '-') ?></td>
                    </tr>
                </table>

                <h5 class="fw-bold mt-4">Visi</h5>
                <p class="fst-italic">
                    “Bandung Barat yang AMANAH (Agamis, Maju, Adaptif, Nyaman, Aspiratif dan Harmonis)”
                </p>

                <h5 class="fw-bold mt-3">Misi</h5>
                <ul>
                    <li>Meningkatkan kualitas SDM Unggul yang berakhlak dan berkarakter.</li>
                    <li>Meningkatkan Produktifitas dan Pertumbuhan Ekonomi Inklusif berbasis potensi sektor unggulan
                        daerah.</li>
                    <li>Mewujudkan Tata Kelola Pemerintahan Yang Profesional, Inovatif, Transparan dan Akuntabel.</li>
                    <li>Mempercepat Pembangunan Infrastruktur dan aksesibilitas Wilayah.</li>
                    <li>Meningkatkan Lingkungan hidup yang Tangguh dan Berkelanjutan.</li>
                    <li>Mewujudkan Kondisi yang Harmonis di Masyarakat berdasarkan kearifan Budaya Lokal.</li>
                </ul>

                <h5 class="fw-bold mt-3">Fungsi</h5>
                <ul>
                    <li>Badan Kepegawaian dan Pengembangan Sumber Daya Manusia merupakan fungsi penunjang
                        Urusan Pemerintahan bidang kepegawaian, dan bidang pendidikan dan pelatihan yang
                        dipimpin oleh seorang Kepala Badan, berkedudukan di bawah dan bertanggungjawab
                        kepada Bupati melalui Sekretaris Daerah.
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tombol Edit -->
        <div class="text-center mt-4">
            <a href="<?= base_url('/admin/profil/edit') ?>" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-pencil-square"></i> Edit Profil
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>