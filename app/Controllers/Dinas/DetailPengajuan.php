<?php

namespace App\Controllers\Dinas;

use App\Models\PengajuanModel;
use App\Models\DokumenUserModel;

trait DetailPengajuan
{
    public function detail($id)
    {
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $pengajuanModel = new PengajuanModel();
        $dokumenUserModel = new DokumenUserModel();
        $dinas = session()->get('user');

        $pengajuan = $pengajuanModel
            ->select('pengajuan.*, dinas.nama_dinas')
            ->join('dinas', 'dinas.id = pengajuan.dinas_id', 'left')
            ->where('pengajuan.dinas_id', $dinas['id'])
            ->where('pengajuan.id', $id)
            ->first();

        if (!$pengajuan) {
            return redirect()->to('/dinas/pengajuan')->with('error', 'Pengajuan tidak ditemukan');
        }

        $dokumen = $dokumenUserModel
            ->where('pengajuan_id', $id)
            ->findAll();

        $data = [
            'title' => 'Detail Pengajuan',
            'pengajuan' => $pengajuan,
            'dokumen' => $dokumen,
        ];

        return view('dinas/pengajuan_detail', $data);
    }
}
