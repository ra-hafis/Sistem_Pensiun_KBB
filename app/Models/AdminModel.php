<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'username', 'email', 'password', 'foto', 'website', 'kepala', 'alamat', 'whatsapp', 'reset_token'];

    protected $useTimestamps = false;
}
