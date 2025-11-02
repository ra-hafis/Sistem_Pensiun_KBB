<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class HapusDaftarPengajuan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function hapus($id)
    {
        // Pastikan request dari AJAX
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Akses tidak valid.'
            ]);
        }

        // Cek apakah data ada
        $pengajuan = $this->db->table('pengajuan')->where('id', $id)->get()->getRowArray();
        if (!$pengajuan) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data pengajuan tidak ditemukan.'
            ]);
        }

        // Hapus file fisik dari dokumen_user
        $dokumen = $this->db->table('dokumen_user')->where('pengajuan_id', $id)->get()->getResultArray();
        foreach ($dokumen as $doc) {
            $path = FCPATH . $doc['file_path'];
            if (is_file($path)) {
                @unlink($path);
            }
        }

        // Hapus data dari database
        $this->db->table('dokumen_user')->where('pengajuan_id', $id)->delete();
        $this->db->table('pengajuan')->where('id', $id)->delete();

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data pengajuan berhasil dihapus.'
        ]);
    }
}
