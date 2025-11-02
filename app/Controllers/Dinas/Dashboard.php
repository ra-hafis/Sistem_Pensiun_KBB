<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Pastikan yang login adalah dinas
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $dinas = session()->get('user'); // data dinas dari session
        $pengajuanModel = new PengajuanModel();

        // Total pengajuan yang diajukan dinas ini
        $totalPengajuan = $pengajuanModel
            ->where('dinas_id', $dinas['id'])
            ->countAllResults();

        // Ambil pengajuan terakhir milik dinas
        $lastPengajuan = $pengajuanModel
            ->where('dinas_id', $dinas['id'])
            ->orderBy('updated_at', 'DESC') // kalau ada kolom updated_at
            ->orderBy('created_at', 'DESC') // fallback jika updated_at tidak ada
            ->first();

        $statusTerakhir = $lastPengajuan['status'] ?? '-';
        $alasan_penolakan = $lastPengajuan['alasan_penolakan'] ?? null;

        // Cek apakah pop-up sudah ditampilkan atau belum
        $showPopup = false;
        if (!session()->getFlashdata('popup_shown')) {
            $showPopup = true;
            session()->setFlashdata('popup_shown', true); // tandai supaya sekali saja
        }

        $data = [
            'user' => $dinas,
            'totalPengajuan' => $totalPengajuan,
            'statusTerakhir' => $statusTerakhir,
            'alasan_penolakan' => $alasan_penolakan,
            'title' => 'Dashboard Dinas',
            'showPopup' => $showPopup
        ];

        return view('dinas/pengajuan_list', $data);
    }
}
