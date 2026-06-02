<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Halaman Utama (URL: /)
    public function index(): string
    {
        // Anda bisa mengarahkan ke landing page atau peta
        return view('maps');
    }

    // Halaman Peta (URL: /maps)
    public function maps(): string
    {
        $data['sekolah'] = []; // Tempatkan data sekolah Anda di sini nanti
        return view('maps', $data);
    }

    // Halaman Full Maps (URL: /fullmaps)
    public function fullmaps(): string
    {
        return view('fullmaps');
    }
}
