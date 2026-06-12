<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;

class Dashboard extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
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
            'total_sekolah' => $this->sekolahModel->countAllResults(),
            'sekolah_list'  => $this->sekolahModel->findAll(), // Untuk mini map preview dan tabel daftar sekolah
        ];

        return view('admin/dashboard', $data);
    }
}
