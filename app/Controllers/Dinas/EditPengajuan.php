<?php

namespace App\Controllers\Dinas;

use App\Models\PengajuanModel;
use App\Models\DokumenUserModel;

trait EditPengajuan
{
    public function edit($id)
    {
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $pengajuanModel = new PengajuanModel();
        $dokumenUserModel = new DokumenUserModel();

        $pengajuan = $pengajuanModel->find($id);
        if (!$pengajuan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data pengajuan tidak ditemukan.");
        }

        $dinas = session()->get('user');
        $dokumen = $dokumenUserModel->where('pengajuan_id', $id)->findAll();

        $data = [
            'title' => 'Edit Pengajuan',
            'pengajuan' => $pengajuan,
            'dokumen' => $dokumen,
            'isEdit' => true,
            'dinas' => $dinas,
            'dokumen_per_jenis' => $dokumenUserModel->getSyaratDokumen(),
        ];

        return view('dinas/pengajuan_tambah', $data);
    }


}
