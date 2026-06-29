<?php

namespace App\Models;

use CodeIgniter\Model;

class SekolahModel extends Model
{
    // Pastikan nama tabelnya menggunakan huruf kecil semua sesuai phpMyAdmin
    protected $table            = 'sekolah';
    protected $primaryKey       = 'id_sekolah'; // sesuaikan dengan primary key tabel Anda
    protected $allowedFields    = ['nama_sekolah', 'jenjang', 'kategori', 'akreditasi', 'latitude', 'longitude', 'alamat', 'foto', 'jumlah_siswa', 'deskripsi_sekolah', 'website', 'tipe_objek', 'koordinat_polygon']; // sesuaikan field Anda
}
