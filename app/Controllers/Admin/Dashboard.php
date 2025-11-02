<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();

        $periode = ['minggu', 'bulan', 'tahun'];
        $data = [];

        foreach ($periode as $p) {
            $data[$p . '_disetujui'] = $this->countPengajuan($model, 'Disetujui', $p);
            $data[$p . '_menunggu'] = $this->countPengajuan($model, 'Menunggu BKPSDM', $p);
            $data[$p . '_ditolak'] = $this->countPengajuan($model, 'Ditolak', $p);
        }

        // Total keseluruhan (pakai tahun)
        $data['total_pengajuan'] = $data['tahun_disetujui'] + $data['tahun_menunggu'] + $data['tahun_ditolak'];
        $data['disetujui'] = $data['tahun_disetujui'];
        $data['menunggu'] = $data['tahun_menunggu'];
        $data['ditolak'] = $data['tahun_ditolak'];

        return view('admin/dashboard', $data);
    }

    private function countPengajuan($model, $status, $periode)
    {
        $builder = $model->where('status', $status);

        switch ($periode) {
            case 'minggu':
                $startOfWeek = date('Y-m-d 00:00:00', strtotime('monday this week'));
                $endOfWeek = date('Y-m-d 23:59:59', strtotime('sunday this week'));
                $builder->where("created_at >=", $startOfWeek)
                    ->where("created_at <=", $endOfWeek);
                break;

            case 'bulan':
                $startOfMonth = date('Y-m-01 00:00:00');
                $endOfMonth = date('Y-m-t 23:59:59');
                $builder->where("created_at >=", $startOfMonth)
                    ->where("created_at <=", $endOfMonth);
                break;

            case 'tahun':
                $startOfYear = date('Y-01-01 00:00:00');
                $endOfYear = date('Y-12-31 23:59:59');
                $builder->where("created_at >=", $startOfYear)
                    ->where("created_at <=", $endOfYear);
                break;
        }

        $count = $builder->countAllResults();
        $model->resetQuery();
        return $count ?? 0;
    }
}
