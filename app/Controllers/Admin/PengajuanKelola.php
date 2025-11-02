<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class PengajuanKelola extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Kelola pengajuan (list + aksi status)
    public function index()
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.id, p.nip, p.nama_pegawai, p.golongan, p.jabatan, p.tanggal_lahir, p.jenis, p.status, p.created_at, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');

        $data['pengajuan'] = $builder->orderBy('p.created_at', 'DESC')->get()->getResultArray();
        $data['dinasList'] = $this->db->table('dinas')->orderBy('nama_dinas', 'ASC')->get()->getResultArray();

        return view('admin/kelola_pengajuan', $data);
    }

    // Update status pengajuan
    public function updateStatus($id, $status)
    {
        $dataUpdate = ['status' => $status];

        // Ambil alasan penolakan
        $alasan = $this->request->getVar('alasan_penolakan') ?? $this->request->getVar('alasan_ditolak');
        if ($status === 'Ditolak') {
            $dataUpdate['alasan_penolakan'] = $alasan ?: 'Tidak ada alasan yang diberikan';
        }

        $this->db->table('pengajuan')->where('id', $id)->update($dataUpdate);

        // Flash pesan
        $msg = $status === 'Ditolak'
            ? 'Pengajuan ID ' . $id . ' berhasil ditolak.'
            : 'Pengajuan ID ' . $id . ' berhasil diubah ke status: ' . $status;
        session()->setFlashdata($status === 'Ditolak' ? 'error' : 'success', $msg);

        // ✅ Diperbaiki: redirect ke rute tanpa /pengajuan/
        return redirect()->to(base_url('admin/pengajuanKelola'));
    }
}
