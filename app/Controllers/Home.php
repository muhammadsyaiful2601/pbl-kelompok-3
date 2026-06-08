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
        $sekolahList = $this->sekolahModel->findAll();
        
        $totalSekolah = count($sekolahList);
        $totalSD = 0;
        $totalSMP = 0;
        
        foreach ($sekolahList as $s) {
            if ($s['jenjang'] == 'SD') $totalSD++;
            if ($s['jenjang'] == 'SMP') $totalSMP++;
        }

        $data = [
            'title'        => 'Peta Sebaran Sekolah | WebGIS Publik',
            'sekolah_list' => $sekolahList,
            'total_sekolah' => $totalSekolah,
            'total_sd'      => $totalSD,
            'total_smp'     => $totalSMP,
        ];
        return view('maps', $data);
    }
}
