<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'user';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = ['username', 'nama_lengkap', 'password', 'role', 'foto'];
    protected $useTimestamps    = false;
}
