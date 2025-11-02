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

    public function index()
    {
        $admin = session()->get('user');
        $admin = $this->adminModel->find($admin['id']);

        return view('admin/profil', [
            'title' => 'Profil Admin',
            'admin' => $admin
        ]);
    }

    public function edit()
    {
        $admin = session()->get('user');
        $admin = $this->adminModel->find($admin['id']);

        return view('admin/profil_edit', [
            'title' => 'Edit Profil',
            'admin' => $admin
        ]);
    }

    public function update()
    {
        $id = session()->get('user')['id'];
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
            // Validasi ekstensi & ukuran
            $ext = strtolower($file->getExtension());
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowedExt)) {
                return redirect()->back()->with('error', 'Format foto hanya boleh JPG, JPEG, PNG, atau GIF');
            }

            if ($file->getSize() > 2 * 1024 * 1024) { // 2MB
                return redirect()->back()->with('error', 'Ukuran foto maksimal 2MB');
            }

            // Simpan foto baru
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);
            $data['foto'] = $newName;

            // Hapus file lama jika ada
            if (!empty($admin['foto']) && file_exists(ROOTPATH . 'public/uploads/' . $admin['foto'])) {
                unlink(ROOTPATH . 'public/uploads/' . $admin['foto']);
            }
        }

        // Update ke database
        $this->adminModel->update($id, $data);

        // Update session dengan data terbaru
        $updatedAdmin = $this->adminModel->find($id);
        session()->set('user', $updatedAdmin);

        return redirect()->to('/admin/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
