<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PengajuanDetail extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Detail pengajuan + dokumen
    public function index($id)
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.*, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');
        $builder->where('p.id', $id);

        $data['pengajuan'] = $builder->get()->getRowArray();

        if (!$data['pengajuan']) {
            return redirect()->to(base_url('admin/pengajuanDaftar'))
                ->with('error', 'Pengajuan tidak ditemukan');
        }

        $data['dokumen'] = $this->db->table('dokumen_user')
            ->where('pengajuan_id', $id)
            ->get()
            ->getResultArray();

        return view('admin/detail_pengajuan', $data);
    }
}
