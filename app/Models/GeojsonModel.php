<?php

namespace App\Models;

use CodeIgniter\Model;

class GeojsonModel extends Model
{
    protected $table            = 'geojson';
    protected $primaryKey       = 'id_geojson';
    protected $allowedFields    = ['nama_geojson', 'file_geojson', 'warna_geojson', 'opacity_geojson', 'is_active'];
    protected $useTimestamps    = true;
}
