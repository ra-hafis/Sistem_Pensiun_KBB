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
        $session = session();
        $adminModel = new AdminModel();

        // Ambil ID admin dari session
        $user = $session->get('user');
        $id = $user['id'] ?? null;

        if (!$id) {
            return redirect()->back()->with('error', 'ID admin tidak ditemukan di session!');
        }

        // Ambil data dari form
        $data = [
            'nama' => trim($this->request->getPost('nama')),
            'username' => trim($this->request->getPost('username')),
            'alamat' => trim($this->request->getPost('alamat')),
            'whatsapp' => trim($this->request->getPost('whatsapp')),
            'email' => trim($this->request->getPost('email')),
            'website' => trim($this->request->getPost('website')),
            'kepala' => trim($this->request->getPost('kepala')),
        ];

        // Validasi wajib diisi
        foreach ($data as $key => $val) {
            if (empty($val)) {
                return redirect()->back()->withInput()->with('error', "Kolom $key wajib diisi!");
            }
        }

        // Ambil data lama
        $admin = $adminModel->find($id);
        $fotoLama = $admin['foto'] ?? null;

        // Upload foto jika ada
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Ukuran foto maksimal 2MB!');
            }

            $ext = $file->getExtension();
            $namaFoto = 'admin_' . $id . '.' . $ext;
            $file->move(ROOTPATH . 'public/uploads', $namaFoto, true);
            $data['foto'] = $namaFoto;

            // Hapus foto lama
            if (!empty($fotoLama) && file_exists(ROOTPATH . 'public/uploads/' . $fotoLama)) {
                unlink(ROOTPATH . 'public/uploads/' . $fotoLama);
            }
        } else {
            // Jika tidak upload foto baru, tetap pakai foto lama
            $data['foto'] = $fotoLama;
        }

        // Update semua field di database
        if ($adminModel->update($id, $data)) {
            // Update session
            $session->set('user', $adminModel->find($id));
            return redirect()->to('/admin/profil')->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil!');
        }
    }
}
