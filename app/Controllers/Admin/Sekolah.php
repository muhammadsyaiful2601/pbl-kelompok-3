<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;
use App\Models\GeojsonModel;

class Sekolah extends BaseController
{
    protected $sekolahModel;
    protected $geojsonModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
        $this->geojsonModel = new GeojsonModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Manajemen Data Sekolah | WebGIS',
            'page_title' => 'Data Sekolah',
            'sekolah'    => $this->sekolahModel->findAll(),
        ];

        return view('admin/sekolah/index', $data);
    }

    public function tambah()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Tambah Sekolah | WebGIS',
            'page_title' => 'Tambah Data Sekolah Baru',
            'validation' => \Config\Services::validation(),
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];

        return view('admin/sekolah/form', $data);
    }

    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $sekolah = $this->sekolahModel->find($id);
        if (!$sekolah) {
            return redirect()->to(base_url('admin/sekolah'))->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'      => 'Edit Sekolah | WebGIS',
            'page_title' => 'Edit Data Sekolah',
            'sekolah'    => $sekolah,
            'validation' => \Config\Services::validation(),
            'active_geojson' => $this->geojsonModel->where('is_active', 1)->findAll(),
        ];

        return view('admin/sekolah/form', $data);
    }

    public function simpan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $id = $this->request->getPost('id_sekolah');

        // Validasi
        $rules = [
            'nama_sekolah' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Nama Sekolah harus diisi.'
                ]
            ],
            'jenjang' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Jenjang harus dipilih.'
                ]
            ],
            'kategori' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Kategori harus dipilih.'
                ]
            ],
            'akreditasi' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Akreditasi harus dipilih.'
                ]
            ],
            'latitude' => [
                'rules'  => 'required|decimal',
                'errors' => [
                    'required' => 'Koordinat Latitude harus diisi.',
                    'decimal'  => 'Format Latitude tidak valid.'
                ]
            ],
            'longitude' => [
                'rules'  => 'required|decimal',
                'errors' => [
                    'required' => 'Koordinat Longitude harus diisi.',
                    'decimal'  => 'Format Longitude tidak valid.'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ],
            'foto' => [
                'rules'  => 'max_size[foto,5120]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maks. 5MB).',
                    'is_image' => 'File yang dipilih bukan gambar.',
                    'mime_in'  => 'Format foto harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $this->request->getPost('foto_lama');

        if ($foto->getError() != 4) {
            // Jika ada foto baru diupload
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/sekolah/', $namaFoto);

            // Hapus foto lama jika sedang edit
            if ($this->request->getPost('foto_lama') && file_exists('uploads/sekolah/' . $this->request->getPost('foto_lama'))) {
                unlink('uploads/sekolah/' . $this->request->getPost('foto_lama'));
            }
        }

        $saveData = [
            'nama_sekolah'      => $this->request->getPost('nama_sekolah'),
            'npsn'              => $this->request->getPost('npsn') ?: null,
            'kepala_sekolah'    => $this->request->getPost('kepala_sekolah') ?: null,
            'jenjang'           => $this->request->getPost('jenjang'),
            'kategori'          => $this->request->getPost('kategori'),
            'akreditasi'        => $this->request->getPost('akreditasi'),
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'alamat'            => $this->request->getPost('alamat'),
            'website'           => $this->request->getPost('website') ?: null,
            'kontak'            => $this->request->getPost('kontak') ?: null,
            'tahun_berdiri'     => $this->request->getPost('tahun_berdiri') ?: null,
            'kurikulum'         => $this->request->getPost('kurikulum') ?: null,
            'deskripsi_sekolah' => $this->request->getPost('deskripsi_sekolah') ?: null,
            'visi'              => $this->request->getPost('visi') ?: null,
            'misi'              => $this->request->getPost('misi') ?: null,
            'foto'              => $namaFoto,
        ];

        if ($id) {
            $this->sekolahModel->update($id, $saveData);
            log_activity('ubah', 'sekolah', $id, 'Mengubah data sekolah: ' . $saveData['nama_sekolah']);
            $msg = 'Data berhasil diupdate';
        } else {
            $this->sekolahModel->insert($saveData);
            $insertId = $this->sekolahModel->getInsertID();
            log_activity('tambah', 'sekolah', $insertId, 'Menambahkan sekolah baru: ' . $saveData['nama_sekolah']);
            $msg = 'Data berhasil disimpan';
        }

        return redirect()->to(base_url('admin/sekolah'))->with('success', $msg);
    }

    public function hapus($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $sekolah = $this->sekolahModel->find($id);
        if ($sekolah) {
            if ($sekolah['foto'] && file_exists('uploads/sekolah/' . $sekolah['foto'])) {
                unlink('uploads/sekolah/' . $sekolah['foto']);
            }
            $this->sekolahModel->delete($id);
            log_activity('hapus', 'sekolah', $id, 'Menghapus data sekolah: ' . $sekolah['nama_sekolah']);
            return redirect()->to(base_url('admin/sekolah'))->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to(base_url('admin/sekolah'))->with('error', 'Data tidak ditemukan');
    }
}
