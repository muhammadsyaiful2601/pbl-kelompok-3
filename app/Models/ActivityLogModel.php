<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'id_user',
        'username',
        'nama_lengkap',
        'role',
        'action',
        'target_table',
        'target_id',
        'description',
        'ip_address',
        'created_at'
    ];
    protected $useTimestamps    = false;
}
