<?php
namespace App\Models;

use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table = 'pengajuan';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'dinas_id',
        'nama_pegawai',
        'nip',
        'golongan',
        'jabatan',
        'tanggal_lahir',
        'jenis',
        'status',
        'alasan_penolakan',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    // ✅ Ambil semua pengajuan dengan nama dinas
    public function getAllWithDinas()
    {
        return $this->select('pengajuan.*, dinas.nama_dinas')
            ->join('dinas', 'dinas.id = pengajuan.dinas_id', 'left')
            ->orderBy('pengajuan.created_at', 'DESC')
            ->findAll();
    }

    // ✅ Ambil detail satu pengajuan dengan nama dinas
    public function getDetailWithDinas($id)
    {
        return $this->select('pengajuan.*, dinas.nama_dinas')
            ->join('dinas', 'dinas.id = pengajuan.dinas_id', 'left')
            ->where('pengajuan.id', $id)
            ->first();
    }
}
