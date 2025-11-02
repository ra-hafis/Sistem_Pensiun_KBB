<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Profil extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    /**
     * Tampilkan halaman profil admin
     */
    public function index()
    {
        $user = session()->get('user');

        // Cek login
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $admin = $this->adminModel->find($user['id']);

        return view('admin/profil', [
            'title' => 'Profil Admin',
            'admin' => $admin
        ]);
    }

    /**
     * Halaman edit profil admin
     */
    public function edit()
    {
        $user = session()->get('user');

        // Cek login
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $admin = $this->adminModel->find($user['id']);

        return view('admin/profil_edit', [
            'title' => 'Edit Profil',
            'admin' => $admin
        ]);
    }

    /**
     * Proses update profil admin
     */
    public function update()
    {
        $user = session()->get('user');

        // Cek login
        if (!$user || !isset($user['id'])) {
            return redirect()->to('/admin/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = $user['id'];
        $admin = $this->adminModel->find($id);

        // Ambil semua data dari form
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'alamat' => $this->request->getPost('alamat'),
            'whatsapp' => $this->request->getPost('whatsapp'),
            'email' => $this->request->getPost('email'),
            'website' => $this->request->getPost('website'),
            'kepala' => $this->request->getPost('kepala'),
        ];

        // Upload foto jika ada
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext = strtolower($file->getExtension());
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowedExt)) {
                return redirect()->back()->with('error', 'Format foto hanya boleh JPG, JPEG, PNG, atau GIF');
            }

            if ($file->getSize() > 2 * 1024 * 1024) { // Maks 2MB
                return redirect()->back()->with('error', 'Ukuran foto maksimal 2MB');
            }

            // Simpan foto baru
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            $data['foto'] = $newName;

            // Hapus file lama
            if (!empty($admin['foto']) && file_exists(ROOTPATH . 'public/uploads/' . $admin['foto'])) {
                unlink(ROOTPATH . 'public/uploads/' . $admin['foto']);
            }
        }

        // Update ke database
        $this->adminModel->update($id, $data);

        // Update session biar data terbaru tampil
        $updatedAdmin = $this->adminModel->find($id);
        session()->set('user', $updatedAdmin);

        return redirect()->to('/admin/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
