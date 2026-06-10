<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SekolahModel;

class Sekolah extends BaseController
{
    protected $sekolahModel;

    public function __construct()
    {
        $this->sekolahModel = new SekolahModel();
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
                'rules'  => 'max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maks. 2MB).',
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
            'jenjang'           => $this->request->getPost('jenjang'),
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'alamat'            => $this->request->getPost('alamat'),
            'website'           => $this->request->getPost('website') ?: null,
            'jumlah_siswa'      => $this->request->getPost('jumlah_siswa') ?: null,
            'deskripsi_sekolah' => $this->request->getPost('deskripsi_sekolah') ?: null,
            'foto'              => $namaFoto,
        ];

        if ($id) {
            $this->sekolahModel->update($id, $saveData);
            $msg = 'Data berhasil diupdate';
        } else {
            $this->sekolahModel->insert($saveData);
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
            return redirect()->to(base_url('admin/sekolah'))->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to(base_url('admin/sekolah'))->with('error', 'Data tidak ditemukan');
    }
}
