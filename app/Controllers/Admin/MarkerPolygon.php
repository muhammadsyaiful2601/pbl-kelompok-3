<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class MarkerPolygon extends BaseController
{
    public function index()
    {
        // Proteksi keamanan session login admin
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Kelola Marker & Polygon | WebGIS Sekolah',
            'page_title' => 'Manajemen Objek Spasial',
        ];

        // Tampilan penampung sementara sebelum file view aslinya kita buat
        return "<h3>Halaman Fitur Tambah Data Marker & Polygon Sedang Disiapkan.</h3> <p>Nanti di sini kita akan integrasikan komponen peta Leaflet.js Draw untuk menggambar area (polygon) dan menaruh titik (marker) sekolah!</p>";

        // JIKA VIEW FORM DRAW SUDAH SIAP, kodenya tinggal diganti menjadi:
        // return view('admin/marker_polygon/index', $data);
    }
}
