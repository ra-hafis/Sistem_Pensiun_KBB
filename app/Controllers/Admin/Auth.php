<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\DinasModel;
use CodeIgniter\I18n\Time;

class Auth extends BaseController
{
    /**
     * Halaman login
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Proses login (Admin / Dinas)
     */
    public function processLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $adminModel = new AdminModel();
        $dinasModel = new DinasModel();

        // Admin
        $admin = $adminModel->where('username', $username)->first();
        if ($admin && password_verify($password, $admin['password'])) {
            session()->set([
                'role' => 'admin',
                'user' => $admin
            ]);
            return redirect()->to('/admin/dashboard');
        }

        // Dinas
        $dinas = $dinasModel->where('username', $username)->first();
        if ($dinas && password_verify($password, $dinas['password'])) {
            session()->set([
                'role' => 'dinas',
                'user' => $dinas
            ]);
            return redirect()->to('/dinas/dashboard');
        }

        return redirect()->back()->with('error', 'Username atau password salah!');
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /**
     * Halaman lupa password
     */
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    /**
     * Proses lupa password 
     */
    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        $adminModel = new AdminModel();
        $dinasModel = new DinasModel();

        $user = $adminModel->where('email', $email)->first();
        $role = 'admin';

        if (!$user) {
            $user = $dinasModel->where('email', $email)->first();
            $role = 'dinas';
        }

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Buat token unik
        $token = bin2hex(random_bytes(32));

        // Simpan token ke DB
        if ($role === 'admin') {
            $adminModel->update($user['id'], ['reset_token' => $token]);
        } else {
            $dinasModel->update($user['id'], ['reset_token' => $token]);
        }

        $resetLink = base_url("/reset-password?token=" . $token);

        // Kirim email
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('rwinandi01@gmail.com', 'BKPSDM');
        $emailService->setSubject('Reset Password BKPSDM');
        $emailService->setMessage("
            Klik link berikut untuk mereset password Anda:<br><br>
            <a href='{$resetLink}'>{$resetLink}</a><br><br>
            Link ini berlaku selama 30 menit.
        ");

        if ($emailService->send()) {
            return redirect()->back()->with('success', 'Email reset password telah dikirim.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email.');
        }
    }

    /**
     * Halaman reset password (dari link email)
     */
    public function resetPassword()
    {
        $token = $this->request->getGet('token');
        if (!$token) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    /**
     * Proses reset password
     */
    public function processResetPassword()
    {
        $token = $this->request->getPost('token');
        $newPass = $this->request->getPost('password');
        $confirmPass = $this->request->getPost('confirm_password');

        if (!$token) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid atau sudah digunakan.');
        }
        if (strlen($newPass) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.');
        }
        if ($newPass !== $confirmPass) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sama!');

        }

        $adminModel = new AdminModel();
        $dinasModel = new DinasModel();

        $user = $adminModel->where('reset_token', $token)->first();
        $role = 'admin';

        if (!$user) {
            $user = $dinasModel->where('reset_token', $token)->first();
            $role = 'dinas';
        }

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Token tidak valid atau kadaluarsa.');
        }

        $hashed = password_hash($newPass, PASSWORD_DEFAULT);

        if ($role === 'admin') {
            $adminModel->update($user['id'], ['password' => $hashed, 'reset_token' => null]);
        } else {
            $dinasModel->update($user['id'], ['password' => $hashed, 'reset_token' => null]);
        }

        return redirect()->to('/login')->with('success', 'Password berhasil diubah. Silakan login.');
    }
}
