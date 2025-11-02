<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\DinasModel;

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
     * Halaman lupa password (username + password lama)
     */
    public function forgotPassword()
    {
        return view('auth/forgot_password'); // view sekarang hanya form username + password lama
    }

    /**
     * Proses lupa password (username + password lama)
     */
    public function processForgotPassword()
    {
        $username = $this->request->getPost('username');
        $oldPassword = $this->request->getPost('old_password');

        $adminModel = new AdminModel();
        $dinasModel = new DinasModel();

        // Cek di admin
        $admin = $adminModel->where('username', $username)->first();
        if ($admin && password_verify($oldPassword, $admin['password'])) {
            session()->set('reset_user', $admin);
            return redirect()->to('/reset-password');
        }

        // Cek di dinas
        $dinas = $dinasModel->where('username', $username)->first();
        if ($dinas && password_verify($oldPassword, $dinas['password'])) {
            session()->set('reset_user', $dinas);
            return redirect()->to('/reset-password');
        }

        return redirect()->back()->with('error', 'Username atau password lama salah.');
    }

    /**
     * Halaman reset password
     */
    public function resetPassword()
    {
        return view('auth/reset_password');
    }

    /**
     * Proses reset password
     */
    public function processResetPassword()
    {
        $newPass = $this->request->getPost('password');
        $confirmPass = $this->request->getPost('confirm_password');

        if (strlen($newPass) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.');
        }
        if ($newPass !== $confirmPass) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak sama!');
        }

        $user = session()->get('reset_user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Sesi reset password tidak valid.');
        }

        // Tentukan model: Admin atau Dinas
        if (isset($user['id'])) {
            $model = isset($user['nama_dinas']) ? new DinasModel() : new AdminModel();

            $model->update($user['id'], [
                'password' => password_hash($newPass, PASSWORD_DEFAULT)
            ]);
        }

        session()->remove('reset_user');

        return redirect()->to('/login')->with('reset_success', 'Password berhasil diubah. Silakan login.');
    }
}
