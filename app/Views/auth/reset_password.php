<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - BKPSDM</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/reset_password.css') ?>" rel="stylesheet">

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

                            <!-- Kolom Kiri: Form Reset Password -->
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="/images/kbb.png" style="width: 120px;" alt="Logo BKPSDM">
                                        <h4 class="mt-3 mb-4 fw-bold">BKPSDM Kabupaten Bandung Barat</h4>
                                    </div>

                                    <!-- Pesan Error / Sukses -->
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('error') ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (session()->getFlashdata('reset_success')): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <?= session()->getFlashdata('reset_success') ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Form Reset Password -->
                                    <form action="<?= base_url('/reset-password/process') ?>" method="post">
                                        <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">

                                        <p class="mb-3">Silakan masukkan password baru Anda.</p>

                                        <!-- Password Baru -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password Baru</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <input type="password" id="password" name="password"
                                                    class="form-control" placeholder="Masukkan password baru" required>
                                            </div>
                                        </div>

                                        <!-- Konfirmasi Password -->
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="toggleConfirmPassword">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                                <input type="password" id="confirm_password" name="confirm_password"
                                                    class="form-control" placeholder="Ulangi password baru" required>
                                            </div>
                                        </div>

                                        <!-- Tombol Reset -->
                                        <div class="d-grid mb-3">
                                            <button class="btn btn-custom" type="submit">Reset Password</button>
                                        </div>

                                        <!-- Link ke Login -->
                                        <div class="text-center mb-3">
                                            <a class="text-muted" href="<?= base_url('/login') ?>">← Kembali ke
                                                Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password JS -->
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });

        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const confirmPassword = document.querySelector("#confirm_password");

        toggleConfirmPassword.addEventListener("click", function () {
            const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);
            this.querySelector("i").classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>