<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DinasModel;

class HapusDinas extends BaseController
{
    protected $dinasModel;

    public function __construct()
    {
        $this->dinasModel = new DinasModel();
    }

    public function index($id)
    {
        $this->dinasModel->delete($id);
        return redirect()->to('/admin/dataakundinas')->with('success', 'Akun dinas berhasil dihapus.');
    }
}
