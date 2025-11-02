<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PengajuanDaftar extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Daftar pengajuan untuk admin
    public function index()
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.id, p.nip, p.nama_pegawai, p.golongan, p.jabatan, p.tanggal_lahir, p.jenis, p.status, p.created_at, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');

        $data['pengajuan'] = $builder->orderBy('p.created_at', 'DESC')->get()->getResultArray();
        $data['dinasList'] = $this->db->table('dinas')->orderBy('nama_dinas', 'ASC')->get()->getResultArray();

        return view('admin/daftar_pengajuan', $data);
    }
}
