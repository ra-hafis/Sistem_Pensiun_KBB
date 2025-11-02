<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DinasModel;

class DataAkunDinas extends BaseController
{
    protected $dinasModel;

    public function __construct()
    {
        $this->dinasModel = new DinasModel();
    }

    public function index()
    {
        $data['dinas'] = $this->dinasModel->findAll();
        return view('admin/data_akun_dinas', $data);
    }
}
