<?php

namespace App\Controllers\Dinas;

use App\Controllers\BaseController;
use App\Controllers\Dinas\LihatPengajuan;
use App\Controllers\Dinas\TambahPengajuan;
use App\Controllers\Dinas\DetailPengajuan;
use App\Controllers\Dinas\EditPengajuan;
use App\Controllers\Dinas\FileViewerPengajuan;

class Pengajuan extends BaseController
{
    use LihatPengajuan;
    use TambahPengajuan;
    use DetailPengajuan;
    use EditPengajuan;
    use FileViewerPengajuan;

    public function index()
    {
        return $this->lihat_pengajuan();
    }
}
