<?php

namespace App\Controllers\Dinas;

use App\Models\PengajuanModel;
use App\Models\DokumenUserModel;

trait TambahPengajuan
{
    public function tambah()
    {
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $dokumenUserModel = new DokumenUserModel();
        $dinas = session()->get('user');

        $data = [
            'title' => 'Tambah Pengajuan',
            'dokumen_per_jenis' => $dokumenUserModel->getSyaratDokumen(),
            'dinas' => $dinas,
            'isEdit' => false,
        ];

        return view('dinas/pengajuan_tambah', $data);
    }

    public function store()
    {
        if (session()->get('role') !== 'dinas') {
            return redirect()->to('/login');
        }

        $pengajuanModel = new PengajuanModel();
        $dokumenUserModel = new DokumenUserModel();
        $dinas = session()->get('user');

        $pengajuanId = $pengajuanModel->insert([
            'dinas_id' => $dinas['id'],
            'nama_pegawai' => $this->request->getPost('nama_pegawai'),
            'nip' => $this->request->getPost('nip'),
            'jabatan' => $this->request->getPost('jabatan'),
            'golongan' => $this->request->getPost('golongan'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis' => $this->request->getPost('jenis'),
            'status' => 'Menunggu BKPSDM',
            'created_at' => date('Y-m-d H:i:s')
        ], true);

        $files = $this->request->getFiles();
        $successCount = 0;
        $failedCount = 0;
        $sizeLimit = 2 * 1024 * 1024; // 🔒 Maksimum 2 MB

        if (isset($files['dokumen_file'])) {
            foreach ($files['dokumen_file'] as $file) {
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $ext = strtolower($file->getClientExtension());
                    $size = $file->getSize(); // Ukuran file (bytes)

                    // ✅ Hanya lanjut kalau PDF dan <= 2MB
                    if ($ext !== 'pdf') {
                        $failedCount++;
                        continue;
                    }

                    if ($size > $sizeLimit) {
                        $failedCount++;
                        continue;
                    }

                    // ✅ Simpan file dan data ke DB jika lolos semua validasi
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);

                    $dokumenUserModel->insert([
                        'pengajuan_id' => $pengajuanId,
                        'nama_dokumen' => $file->getClientName(),
                        'file_path' => 'uploads/' . $newName,
                        'wajib' => 1,
                    ]);

                    $successCount++;
                }
            }
        }

        $msg = "Upload selesai: $successCount file berhasil.";
        if ($failedCount > 0) {
            $msg .= " $failedCount file gagal (hanya PDF & max 2MB).";
        }

        return redirect()->to('/dinas/pengajuan')->with('message', $msg);
    }
}
