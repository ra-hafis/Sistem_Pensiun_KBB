<?php

namespace App\Controllers\Dinas;

use App\Models\PengajuanModel;

trait LihatPengajuan
{
    public function lihat_pengajuan()
    {
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $pengajuanModel = new PengajuanModel();
        $dinas = session()->get('user');

        $pengajuan = $pengajuanModel
            ->select('pengajuan.*, dinas.nama_dinas')
            ->join('dinas', 'dinas.id = pengajuan.dinas_id', 'left')
            ->where('pengajuan.dinas_id', $dinas['id'])
            ->orderBy('pengajuan.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Lihat Pengajuan',
            'pengajuan' => $pengajuan,
        ];

        $ditolak = array_filter($pengajuan, fn($p) => $p['status'] === 'Ditolak');
        if (!empty($ditolak)) {
            $pesan = "Pengajuan pensiun berikut ditolak:\n";
            foreach ($ditolak as $p) {
                $pesan .= "- " . $p['nama_pegawai'];
                if (!empty($p['alasan_penolakan'])) {
                    $pesan .= " (Alasan: " . $p['alasan_penolakan'] . ")";
                }
                $pesan .= "\n";
            }
            $data['popup_penolakan'] = $pesan;
        }

        return view('dinas/lihat_pengajuan', $data);
    }
}
