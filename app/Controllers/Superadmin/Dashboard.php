<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\UserModel;
use App\Models\GeojsonModel;

class Dashboard extends BaseController
{
    protected $sekolahModel;
    protected $userModel;
    protected $geojsonModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
        $this->userModel = new UserModel();
        $this->geojsonModel = new GeojsonModel();
    }

    public function index()
    {
        // Memastikan pengguna harus login dan memiliki role superadmin
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'         => 'Dashboard Super Admin | WebGIS Sekolah',
            'page_title'    => 'Ringkasan Sistem',
            'total_admin'   => $this->userModel->where('role', 'admin')->countAllResults(),
            'total_sekolah' => $this->sekolahModel->countAllResults(),
            'total_sd'      => $this->sekolahModel->where('jenjang', 'SD')->countAllResults(),
            'total_smp'     => $this->sekolahModel->where('jenjang', 'SMP')->countAllResults(),
            'sekolah_list'  => $this->sekolahModel->findAll(),
            'active_geojson'=> $this->geojsonModel->where('is_active', 1)->findAll(),
        ];

        return view('superadmin/dashboard', $data);
    }
}
