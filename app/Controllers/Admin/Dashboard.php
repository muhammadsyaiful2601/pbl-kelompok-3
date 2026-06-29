<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\GeojsonModel;

class Dashboard extends BaseController
{
    protected $sekolahModel;
    protected $geojsonModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
        $this->geojsonModel = new GeojsonModel();
    }

    public function index()
    {
        // Memastikan pengguna harus login terlebih dahulu sebelum masuk dashboard
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        // Mengambil total data dari database untuk ditampilkan di ringkasan dashboard
        $data = [
            'title'        => 'Dashboard Admin | WebGIS Sekolah',
            'page_title'   => 'Dashboard Utama',
            'total_sd'     => $this->sekolahModel->where('jenjang', 'SD')->countAllResults(),
            'total_smp'    => $this->sekolahModel->where('jenjang', 'SMP')->countAllResults(),
            'total_tk'     => $this->sekolahModel->where('jenjang', 'TK')->countAllResults(),
            'total_sekolah' => $this->sekolahModel->countAllResults(),
            'sekolah_list'  => $this->sekolahModel->findAll(),
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];

        return view('admin/dashboard', $data);
    }
}
