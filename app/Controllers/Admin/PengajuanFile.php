<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;

class PengajuanFile extends BaseController
{
    //menampilkan file langsung di browser berdasarkan nama file yang dikirim lewat URL
    public function view($filename)
    {
        $path = FCPATH . 'uploads/' . $filename;

        if (!file_exists($path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->setHeader('Content-Type', mime_content_type($path))
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody(file_get_contents($path));
    }
    // Download file
    public function download($filename)
    {
        $path = FCPATH . 'uploads/' . $filename;

        if (!file_exists($path)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $this->response
            ->download($path, null)
            ->setFileName($filename);
    }
}
