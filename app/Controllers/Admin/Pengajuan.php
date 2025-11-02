<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pengajuan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    // Daftar pengajuan untuk admin
    public function daftar()
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.id, p.nip, p.nama_pegawai, p.golongan, p.tanggal_lahir, p.jenis, p.status, p.created_at, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');

        $data['pengajuan'] = $builder
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Ambil daftar dinas unik buat filter
        $data['dinasList'] = $this->db->table('dinas')->orderBy('nama_dinas', 'ASC')->get()->getResultArray();

        return view('admin/daftar_pengajuan', $data);
    }

    // Kelola pengajuan (list + aksi status)
    public function kelola()
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.id, p.nip, p.nama_pegawai, p.golongan, p.tanggal_lahir, p.jenis, p.status,p.created_at, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');

        $data['pengajuan'] = $builder
            ->orderBy('p.created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Ambil daftar dinas unik buat filter
        $data['dinasList'] = $this->db->table('dinas')->orderBy('nama_dinas', 'ASC')->get()->getResultArray();

        return view('admin/kelola_pengajuan', $data);
    }

    // Detail pengajuan + dokumen
    public function detail($id)
    {
        $builder = $this->db->table('pengajuan as p');
        $builder->select('p.*, d.nama_dinas');
        $builder->join('dinas as d', 'd.id = p.dinas_id', 'left');
        $builder->where('p.id', $id);

        $data['pengajuan'] = $builder->get()->getRowArray();

        if (!$data['pengajuan']) {
            return redirect()->to(base_url('admin/pengajuan/daftar'))
                ->with('error', 'Pengajuan tidak ditemukan');
        }

        $data['dokumen'] = $this->db->table('dokumen_user')
            ->where('pengajuan_id', $id)
            ->get()
            ->getResultArray();

        return view('admin/detail_pengajuan', $data);
    }

    // Update status pengajuan
    public function updateStatus($id, $status, $redirectTo = 'admin')
    {
        $dataUpdate = ['status' => $status];

        // Ambil alasan penolakan dari form
        $alasan = $this->request->getVar('alasan_penolakan') ?? $this->request->getVar('alasan_ditolak');
        if ($status === 'Ditolak') {
            $dataUpdate['alasan_penolakan'] = !empty($alasan) ? $alasan : 'Tidak ada alasan yang diberikan';
        }

        // Update ke database
        $this->db->table('pengajuan')
            ->where('id', $id)
            ->update($dataUpdate);

        // Notifikasi flash untuk admin
        if ($status === 'Ditolak') {
            session()->setFlashdata('error', 'Pengajuan ID ' . $id . ' berhasil ditolak.');
            // Flashdata tambahan supaya modal dinas hanya muncul sekali
            session()->setFlashdata('show_modal_ditolak', true);
        } else {
            session()->setFlashdata('success', 'Pengajuan ID ' . $id . ' berhasil diubah ke status: ' . $status);
        }

        // Flash untuk dinas agar tahu update status terakhir
        session()->setFlashdata('status_update', [
            'status' => $status,
            'alasan_penolakan' => $dataUpdate['alasan_penolakan'] ?? null,
        ]);

        return redirect()->to('/admin/pengajuan/kelola');
    }

    // View file dokumen (supaya tidak auto-download)
    public function viewFile($filename)
    {
        $path = FCPATH . 'uploads/' . $filename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody(file_get_contents($path));
    }
}
