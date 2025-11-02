<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DinasModel;

class TambahDinas extends BaseController
{
    protected $dinasModel;

    public function __construct()
    {
        $this->dinasModel = new DinasModel();
    }

    public function index()
    {
        return view('admin/tambah_dinas');
    }

    public function simpan()
    {
        $username = $this->request->getPost('username');

        // 🔍 Cek apakah username sudah ada
        $existing = $this->dinasModel->where('username', $username)->first();

        if ($existing) {
            // Jika sudah ada, tampilkan notifikasi error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data sudah digunakan! Username "' . esc($username) . '" sudah terdaftar.');
        }

        // ✅ Jika belum ada, lanjut insert
        $this->dinasModel->insert([
            'nama_dinas' => $this->request->getPost('nama_dinas'),
            'username' => $username,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d'),
        ]);

        return redirect()->to('/admin/dataakundinas')
            ->with('success', 'Akun dinas berhasil ditambahkan.');
    }
}
