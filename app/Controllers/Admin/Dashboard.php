<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class Dashboard extends BaseController
{
    /**
     * Menampilkan halaman dashboard admin BKPSDM
     */
    public function index()
    {
        $model = new PengajuanModel(); // Memanggil model untuk akses data pengajuan

        $periode = ['minggu', 'bulan', 'tahun']; // Periode waktu untuk statistik
        $data = [];

        // Looping tiap periode untuk hitung jumlah pengajuan berdasarkan status
        foreach ($periode as $p) {
            $data[$p . '_disetujui'] = $this->countPengajuan($model, 'Disetujui', $p);
            $data[$p . '_menunggu'] = $this->countPengajuan($model, 'Menunggu BKPSDM', $p);
            $data[$p . '_ditolak'] = $this->countPengajuan($model, 'Ditolak', $p);
        }

        // Total keseluruhan pengajuan dalam setahun
        $data['total_pengajuan'] = $data['tahun_disetujui'] + $data['tahun_menunggu'] + $data['tahun_ditolak'];
        $data['disetujui'] = $data['tahun_disetujui'];
        $data['menunggu'] = $data['tahun_menunggu'];
        $data['ditolak'] = $data['tahun_ditolak'];

        // Kirim data ke view dashboard admin
        return view('admin/dashboard', $data);
    }

    /**
     * Fungsi untuk menghitung jumlah pengajuan berdasarkan status dan periode waktu
     *
     * @param PengajuanModel $model  Model untuk akses data pengajuan
     * @param string $status         Status pengajuan (Disetujui, Menunggu, Ditolak)
     * @param string $periode        Periode waktu (minggu, bulan, tahun)
     * @return int                   Jumlah data yang sesuai
     */
    private function countPengajuan($model, $status, $periode)
    {
        $builder = $model->where('status', $status); // Filter data berdasarkan status

        // Filter waktu berdasarkan periode
        switch ($periode) {
            case 'minggu':
                // Ambil data dari Senin sampai Minggu minggu ini
                $startOfWeek = date('Y-m-d 00:00:00', strtotime('monday this week'));
                $endOfWeek = date('Y-m-d 23:59:59', strtotime('sunday this week'));
                $builder->where("created_at >=", $startOfWeek)
                    ->where("created_at <=", $endOfWeek);
                break;

            case 'bulan':
                // Ambil data dari tanggal 1 sampai akhir bulan ini
                $startOfMonth = date('Y-m-01 00:00:00');
                $endOfMonth = date('Y-m-t 23:59:59');
                $builder->where("created_at >=", $startOfMonth)
                    ->where("created_at <=", $endOfMonth);
                break;

            case 'tahun':
                // Ambil data dari awal sampai akhir tahun berjalan
                $startOfYear = date('Y-01-01 00:00:00');
                $endOfYear = date('Y-12-31 23:59:59');
                $builder->where("created_at >=", $startOfYear)
                    ->where("created_at <=", $endOfYear);
                break;
        }

        // Hitung total data sesuai kriteria
        $count = $builder->countAllResults();

        // Reset query agar tidak bentrok di pemanggilan berikutnya
        $model->resetQuery();

        // Kembalikan hasil perhitungan
        return $count ?? 0;
    }
}
