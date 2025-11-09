<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DinasModel;
use CodeIgniter\Database\Exceptions\DatabaseException;

class EditDinas extends BaseController
{
    protected $dinasModel;

    public function __construct()
    {
        $this->dinasModel = new DinasModel();
    }

    public function index($id)
    {
        $data['dinas'] = $this->dinasModel->find($id);

        if (!$data['dinas']) {
            return redirect()->to('/admin/dataakundinas')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/edit_dinas', $data);
    }

    public function update($id)
    {
        $nama_dinas = trim($this->request->getPost('nama_dinas'));
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        // Cek duplikat username
        $cekUsername = $this->dinasModel
            ->where('username', $username)
            ->where('id !=', $id) // kecuali data sendiri
            ->first();

        // Cek duplikat nama dinas
        $cekNama = $this->dinasModel
            ->where('nama_dinas', $nama_dinas)
            ->where('id !=', $id)
            ->first();

        if ($cekUsername || $cekNama) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data duplikat atau format salah. Nama Dinas atau Username sudah digunakan.');
        }

        $data = [
            'nama_dinas' => $nama_dinas,
            'username' => $username,
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $this->dinasModel->update($id, $data);
            return redirect()->to('/admin/dataakundinas')->with('success', 'Akun dinas berhasil diperbarui.');
        } catch (DatabaseException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data duplikat atau format salah. Silakan periksa kembali.');
        }
    }
}
