<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - BKPSDM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/forgot_password.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <section class="gradient-form">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black shadow-lg">
                        <div class="row g-0">

                            <!-- Kolom Kiri: Form Lupa Password -->
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <!-- Logo + Judul -->
                                    <div class="text-center">
                                        <img src="/images/kbb.png" style="width: 120px;" alt="Logo BKPSDM">
                                        <h4 class="mt-3 mb-4 fw-bold">BKPSDM Kabupaten Bandung Barat</h4>
                                    </div>

                                    <!-- Pesan Error/Sukses -->
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                                    <?php endif; ?>
                                    <?php if (session()->getFlashdata('success')): ?>
                                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                                    <?php endif; ?>

                                    <!-- Form Lupa Password via Email -->
                                    <form action="<?= base_url('/forgot-password/process') ?>" method="post">
                                        <p class="mb-3">Masukkan alamat email yang terdaftar untuk menerima tautan reset
                                            password.</p>

                                        <!-- Email -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    placeholder="Masukkan Email Anda" required>
                                            </div>
                                        </div>

                                        <!-- Tombol Kirim -->
                                        <div class="d-grid mb-3">
                                            <button class="btn btn-custom" type="submit">Kirim Tautan Reset</button>
                                        </div>

                                        <!-- Link Balik ke Login -->
                                        <div class="text-center mb-3">
                                            <a class="text-muted" href="<?= base_url('/login') ?>">← Kembali ke
                                                Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Info -->
                            <div
                                class="col-lg-6 d-flex flex-column align-items-center justify-content-center gradient-custom-2 text-white p-4">
                                <div class="text-center">
                                    <h4 class="mb-3">Badan Kepegawaian dan Pengembangan SDM</h4>
                                    <p class="small mb-0">Kabupaten Bandung Barat</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>