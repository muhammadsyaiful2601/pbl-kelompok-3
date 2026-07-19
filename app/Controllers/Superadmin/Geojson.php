<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\GeojsonModel;

class Geojson extends BaseController
{
    protected $geojsonModel;

    public function __construct()
    {
        $this->geojsonModel = new GeojsonModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Kelola GeoJSON | WebGIS Sekolah',
            'page_title' => 'Manajemen Lapisan GeoJSON',
            'geojsons'   => $this->geojsonModel->findAll(),
        ];

        return view('superadmin/geojson/index', $data);
    }

    public function scan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $directory = FCPATH . 'assets/geojson/id1305_tanah_datar';
        if (is_dir($directory)) {
            $files = glob($directory . '/*.geojson');
            $count = 0;
            foreach ($files as $file) {
                $filename = basename($file);
                $existing = $this->geojsonModel->where('file_geojson', 'assets/geojson/id1305_tanah_datar/' . $filename)->first();
                if (!$existing) {
                    $cleanName = preg_replace('/^id\d+_/', '', $filename);
                    $cleanName = str_replace(['_', '.geojson'], [' ', ''], $cleanName);

                    $this->geojsonModel->save([
                        'nama_geojson' => $cleanName,
                        'file_geojson' => 'assets/geojson/id1305_tanah_datar/' . $filename,
                        'is_active'    => 0
                    ]);
                    $count++;
                }
            }
            if ($count > 0) {
                log_activity('tambah', 'geojson', null, "Melakukan pemindaian GeoJSON, berhasil menambahkan $count file baru.");
            }
            return redirect()->to(base_url('superadmin/geojson'))->with('success', "Berhasil memindai $count file GeoJSON baru.");
        }

        return redirect()->to(base_url('superadmin/geojson'))->with('error', "Direktori tidak ditemukan.");
    }

    public function clean()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $geojsons = $this->geojsonModel->findAll();
        $count = 0;
        foreach ($geojsons as $gj) {
            $oldName = $gj['nama_geojson'];
            if (preg_match('/^id\d+\s/', $oldName)) {
                $newName = preg_replace('/^id\d+\s/', '', $oldName);
                $this->geojsonModel->update($gj['id_geojson'], ['nama_geojson' => $newName]);
                $count++;
            }
        }
        if ($count > 0) {
            log_activity('ubah', 'geojson', null, "Melakukan pembersihan nama lapisan wilayah GeoJSON, berhasil memperbarui $count nama wilayah.");
        }

        return redirect()->to(base_url('superadmin/geojson'))->with('success', "Berhasil membersihkan $count nama wilayah.");
    }

    public function edit($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $geojson = $this->geojsonModel->find($id);
        if (!$geojson) {
            return redirect()->to(base_url('superadmin/geojson'))->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title'      => 'Atur Gaya GeoJSON | WebGIS Sekolah',
            'page_title' => 'Konfigurasi Visual Layer',
            'geojson'    => $geojson,
        ];

        return view('superadmin/geojson/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $rules = [
            'nama_geojson'    => 'required',
            'warna_geojson'   => 'required',
            'opacity_geojson' => 'required|decimal|greater_than[0]|less_than_equal_to[1]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->geojsonModel->update($id, [
            'nama_geojson'    => $this->request->getPost('nama_geojson'),
            'warna_geojson'   => $this->request->getPost('warna_geojson'),
            'opacity_geojson' => $this->request->getPost('opacity_geojson'),
        ]);
        log_activity('ubah', 'geojson', $id, "Mengubah pengaturan visual layer GeoJSON: " . $this->request->getPost('nama_geojson'));

        return redirect()->to(base_url('superadmin/geojson'))->with('success', 'Pengaturan visual berhasil disimpan.');
    }

    public function toggle($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $geojson = $this->geojsonModel->find($id);
        if ($geojson) {
            $this->geojsonModel->update($id, [
                'is_active' => $geojson['is_active'] ? 0 : 1
            ]);
            $statusStr = $geojson['is_active'] ? 'menonaktifkan' : 'mengaktifkan';
            log_activity('ubah', 'geojson', $id, "Mengubah status layer GeoJSON, " . $statusStr . " layer: " . $geojson['nama_geojson']);
            return redirect()->to(base_url('superadmin/geojson'))->with('success', 'Status GeoJSON berhasil diperbarui.');
        }

        return redirect()->to(base_url('superadmin/geojson'))->with('error', 'Data tidak ditemukan.');
    }

    public function hapus($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $geojson = $this->geojsonModel->find($id);
        if ($geojson) {
            $this->geojsonModel->delete($id);
            log_activity('hapus', 'geojson', $id, "Menghapus data GeoJSON: " . $geojson['nama_geojson']);
            return redirect()->to(base_url('superadmin/geojson'))->with('success', 'Data GeoJSON berhasil dihapus dari sistem.');
        }
        return redirect()->to(base_url('superadmin/geojson'))->with('error', 'Data tidak ditemukan.');
    }

    public function hapus_multiple()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $ids = $this->request->getPost('ids');
        if (!empty($ids) && is_array($ids)) {
            $deleted = 0;
            foreach ($ids as $id) {
                $geojson = $this->geojsonModel->find($id);
                if ($geojson) {
                    $this->geojsonModel->delete($id);
                    log_activity('hapus', 'geojson', $id, "Menghapus data GeoJSON: " . $geojson['nama_geojson']);
                    $deleted++;
                }
            }
            if ($deleted > 0) {
                return redirect()->to(base_url('superadmin/geojson'))->with('success', "$deleted data GeoJSON berhasil dihapus dari sistem.");
            }
        }
        return redirect()->to(base_url('superadmin/geojson'))->with('error', 'Tidak ada data yang dipilih.');
    }
}
