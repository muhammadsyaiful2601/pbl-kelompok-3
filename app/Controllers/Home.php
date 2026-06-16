<?php

namespace App\Controllers;

use App\Models\SekolahModel;

class Home extends BaseController
{
    protected $sekolahModel;
    protected $geojsonModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
        $this->geojsonModel = new \App\Models\GeojsonModel();
    }

    public function index()
    {
        $sekolahList = $this->sekolahModel->findAll();

        $totalSekolah = count($sekolahList);
        $totalSD = 0;
        $totalSMP = 0;
        $totalTK = 0;

        foreach ($sekolahList as $s) {
            if ($s['jenjang'] == 'SD') $totalSD++;
            if ($s['jenjang'] == 'SMP') $totalSMP++;
            if ($s['jenjang'] == 'TK') $totalTK++;
        }

        $data = [
            'title'         => 'Peta Sebaran Sekolah | WebGIS Publik',
            'sekolah_list'  => $sekolahList,
            'total_sekolah' => $totalSekolah,
            'total_sd'      => $totalSD,
            'total_smp'     => $totalSMP,
            'total_tk'      => $totalTK,
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];
        return view('maps', $data);
    }

    public function fullmaps()
    {
        $sekolahList = $this->sekolahModel->findAll();

        $totalSekolah = count($sekolahList);
        $totalSD = 0;
        $totalSMP = 0;
        $totalTK = 0;

        foreach ($sekolahList as $s) {
            if ($s['jenjang'] == 'SD') {
                $totalSD++;
            } elseif ($s['jenjang'] == 'SMP') {
                $totalSMP++;
            } elseif ($s['jenjang'] == 'TK') {
                $totalTK++;
            }
        }

        $data = [
            'title'          => 'Peta Sebaran Sekolah | WebGIS Publik',
            'sekolah_list'   => $sekolahList,
            'total_sekolah'  => $totalSekolah,
            'total_sd'       => $totalSD,
            'total_smp'      => $totalSMP,
            'total_tk'       => $totalTK,
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];
        return view('fullmaps', $data);
    }

    public function detail($id)
    {
        $sekolah = $this->sekolahModel->find($id);

        if (!$sekolah) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sekolah dengan ID $id tidak ditemukan.");
        }

        $data = [
            'title'          => 'Detail Sekolah | ' . $sekolah['nama_sekolah'],
            'sekolah'        => $sekolah,
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];

        return view('detail', $data);
    }
}
