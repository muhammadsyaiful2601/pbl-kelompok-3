<?php

namespace App\Controllers;

use App\Models\SekolahModel;

class Home extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Peta Sebaran Sekolah | WebGIS Publik',
            // Mengambil semua baris data spasial dari database
            'sekolah_list' => $this->sekolahModel->findAll()
        ];
        return view('maps', $data); // Berkas maps Anda di halaman depanpublik
    }
}
