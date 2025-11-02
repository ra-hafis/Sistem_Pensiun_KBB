<?php
namespace App\Models;

use CodeIgniter\Model;

class DokumenUserModel extends Model
{
    protected $table = 'dokumen_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pengajuan_id', 'nama_dokumen', 'file_path', 'wajib', 'uploaded_at'];

    // Ambil dokumen persyaratan berdasarkan jenis pengajuan
    public function getSyaratDokumen()
    {
        return [
            'BUP' => [
                ['nama' => 'Daftar Perorangan Calon Pensiun (DPCP)', 'wajib' => 1],
                ['nama' => 'Surat Penyataan tidak pernah dijatuhi HD Tingkat Sedang/Berat 1 tahun terakhir (Hukdis)', 'wajib' => 1],
                ['nama' => 'SK Kenaikan Pangkat Terakhir', 'wajib' => 1],
                ['nama' => 'Surat Pernyataan tidak sedang menjalani proses pidana/pernah dipidana (Hukda)', 'wajib' => 1],
                ['nama' => 'SK CPNS', 'wajib' => 1],
                ['nama' => 'SKP 1 Tahun terakhir bernilai baik', 'wajib' => 1],
                ['nama' => 'Kartu Keluarga', 'wajib' => 0],
                ['nama' => 'Akta Nikah', 'wajib' => 0],
                ['nama' => 'Akta Cerai', 'wajib' => 0],
                ['nama' => 'Akta Anak', 'wajib' => 0],
                ['nama' => 'Ijazah dan transkrip nilai terakhir (asli/fc legalisir)', 'wajib' => 0],
                ['nama' => 'Pas Foto formal (latar biru/merah)', 'wajib' => 0],
            ],
            'APS' => [
                ['nama' => 'Daftar Perorangan Calon Pensiun (DPCP)', 'wajib' => 1],
                ['nama' => 'SK Kenaikan Pangkat Terakhir', 'wajib' => 1],
                ['nama' => 'Surat Penyataan tidak pernah dijatuhi HD Tingkat Sedang/Berat 1 tahun terakhir (Hukdis)', 'wajib' => 1],
                ['nama' => 'Surat Pernyataan tidak sedang menjalani proses pidana/pernah dipidana (Hukda)', 'wajib' => 1],
                ['nama' => 'SK CPNS', 'wajib' => 1],
                ['nama' => 'Surat permohonan berhenti atas permintaan sendiri sebagai PNS', 'wajib' => 1],
                ['nama' => 'Surat persetujuan berhenti atas permintaan sendiri sebagai PNS dari perangkat daerah', 'wajib' => 1],
                ['nama' => 'Kartu Keluarga', 'wajib' => 0],
                ['nama' => 'Akta Nikah', 'wajib' => 0],
                ['nama' => 'Akta Cerai', 'wajib' => 0],
                ['nama' => 'Akta Anak', 'wajib' => 0],
                ['nama' => 'Ijazah dan transkrip nilai terakhir (asli/fc legalisir)', 'wajib' => 0],
                ['nama' => 'Pas Foto formal (latar biru/merah)', 'wajib' => 0],
            ],
            'Meninggal Dunia Aktif' => [
                ['nama' => 'Daftar Perorangan Calon Pensiun (DPCP)', 'wajib' => 1],
                ['nama' => 'Surat Penyataan tidak pernah dijatuhi HD Tingkat Sedang/Berat 1 tahun terakhir (Hukdis)', 'wajib' => 1],
                ['nama' => 'SK Kenaikan Pangkat Terakhir', 'wajib' => 1],
                ['nama' => 'Surat Pernyataan tidak sedang menjalani proses pidana/pernah dipidana (Hukda)', 'wajib' => 1],
                ['nama' => 'SK CPNS', 'wajib' => 1],
                ['nama' => 'SKP 1 Tahun terakhir bernilai baik', 'wajib' => 1],
                ['nama' => 'Surat Keterangan Kematian', 'wajib' => 1],
                ['nama' => 'Surat keterangan janda/duda dari desa/kecamatan', 'wajib' => 1],
                ['nama' => 'Kartu Keluarga', 'wajib' => 0],
                ['nama' => 'Akta Nikah', 'wajib' => 0],
                ['nama' => 'Akta Cerai', 'wajib' => 0],
                ['nama' => 'Akta Anak', 'wajib' => 0],
                ['nama' => 'Ijazah dan transkrip nilai terakhir (asli/fc legalisir)', 'wajib' => 0],
                ['nama' => 'Pas Foto formal (latar biru/merah)', 'wajib' => 0],
            ],
            'Uzur' => [
                ['nama' => 'Daftar Perorangan Calon Pensiun (DPCP)', 'wajib' => 1],
                ['nama' => 'SK Kenaikan Pangkat Terakhir', 'wajib' => 1],
                ['nama' => 'Surat Pernyataan tidak sedang menjalani proses pidana/pernah dipidana (Hukda)', 'wajib' => 1],
                ['nama' => 'SK CPNS', 'wajib' => 1],
                ['nama' => 'Surat Keterangan tim penguji kesehatan', 'wajib' => 1],
                ['nama' => 'Kartu Keluarga', 'wajib' => 0],
                ['nama' => 'Akta Nikah', 'wajib' => 0],
                ['nama' => 'Akta Cerai', 'wajib' => 0],
                ['nama' => 'Akta Anak', 'wajib' => 0],
                ['nama' => 'Ijazah dan transkrip nilai terakhir (asli/fc legalisir)', 'wajib' => 0],
                ['nama' => 'Pas Foto formal (latar biru/merah)', 'wajib' => 0],
            ],
            // Jenis Baru
            'Pemberhentian Karena Tewas' => [
                ['nama' => 'Surat Pengantar instansi', 'wajib' => 1],
                ['nama' => 'Surat Kronologis', 'wajib' => 1],
                ['nama' => 'Surat Kematian dari Dokter', 'wajib' => 1],
                ['nama' => 'SK Pangkat terakhir', 'wajib' => 1],
                ['nama' => 'Surat/akta nikah', 'wajib' => 0],
                ['nama' => 'Akta cerai', 'wajib' => 0],
                ['nama' => 'Akta anak', 'wajib' => 0],
                ['nama' => 'Surat Keterangan Janda/Duda', 'wajib' => 1],
                ['nama' => 'Surat Tugas', 'wajib' => 1],
                ['nama' => 'Surat Berita acara kepolisian (bagi yang meninggal karena kecelakaan)', 'wajib' => 0],
                ['nama' => 'Surat Visum Rekam medis', 'wajib' => 0],
                ['nama' => 'DPCP', 'wajib' => 1],
                ['nama' => 'SK CPNS', 'wajib' => 1],
                ['nama' => 'Akta Kematian', 'wajib' => 1],
            ],
            'Pemberhentian PPPK karena Masa Kerja Berakhir' => [
                ['nama' => 'Surat Pengantar instansi', 'wajib' => 1],
                ['nama' => 'SK PPPK', 'wajib' => 1],
            ],
            'Pemberhentian PPPK karena Meninggal Dunia' => [
                ['nama' => 'Surat Pengantar instansi', 'wajib' => 1],
                ['nama' => 'SK PPPK', 'wajib' => 1],
                ['nama' => 'Akta Kematian', 'wajib' => 1],
            ],
        ];
    }
}
