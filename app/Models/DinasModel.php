<?php

namespace App\Models;

use CodeIgniter\Model;

class DinasModel extends Model
{
    protected $table = 'dinas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_dinas', 'username', 'email', 'password', 'reset_token', 'created_at'];
}
