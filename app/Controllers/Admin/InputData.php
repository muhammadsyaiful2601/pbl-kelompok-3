<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InputData extends BaseController
{
    public function index()
    {
        // Proteksi keamanan session login admin
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Input Data Spasial | WebGIS Sekolah',
            'page_title' => 'Form Input Data Baru',
        ];

        // Sementara kita return teks ini dulu, nanti kita ganti dengan view asli
        return "<h3>Halaman Input Data Baru Sedang Disiapkan.</h3> <p>Nanti kita akan panggil view form spasial di sini!</p>";

        // JIKA VIEW SUDAH SIAP, kodenya tinggal diganti menjadi:
        // return view('admin/input_data/index', $data);
    }
}
