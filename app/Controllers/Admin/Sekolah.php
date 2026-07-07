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
            'npsn' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'NPSN harus diisi.'
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
        ];

        // Hanya validasi berkas fisik jika tidak menggunakan upload Base64
        if (empty($this->request->getPost('foto_base64'))) {
            $rules['foto'] = [
                'rules'  => 'max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto terlalu besar (Maks. 10MB).',
                    'is_image' => 'File yang dipilih bukan gambar.',
                    'mime_in'  => 'Format foto harus JPG, JPEG, atau PNG.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = $this->request->getPost('foto_lama');
        $fotoBase64 = $this->request->getPost('foto_base64');

        if (!empty($fotoBase64)) {
            // Proses upload via Base64 (WAF Bypass)
            if (preg_match('/^data:image\/(\w+);base64,/', $fotoBase64, $type)) {
                $data = substr($fotoBase64, strpos($fotoBase64, ',') + 1);
                $type = strtolower($type[1]); // jpg, jpeg, png

                if (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $decodedData = base64_decode($data);
                    if ($decodedData !== false) {
                        $namaFoto = bin2hex(random_bytes(16)) . '.' . ($type === 'jpeg' ? 'jpg' : $type);
                        $uploadPath = FCPATH . 'uploads/sekolah/';

                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        // Hapus foto lama jika sedang edit
                        if ($this->request->getPost('foto_lama') && file_exists($uploadPath . $this->request->getPost('foto_lama'))) {
                            @unlink($uploadPath . $this->request->getPost('foto_lama'));
                        }

                        file_put_contents($uploadPath . $namaFoto, $decodedData);
                    }
                }
            }
        } else if ($foto && $foto->getError() != 4) {
            // Cek apakah upload file valid dan bebas kesalahan engine
            if (!$foto->isValid()) {
                $errorStr = $foto->getErrorString();
                if ($foto->getError() === UPLOAD_ERR_INI_SIZE) {
                    $errorStr = 'Ukuran berkas foto melebihi batas maksimal server (upload_max_filesize).';
                }
                return redirect()->back()->withInput()->with('error', $errorStr);
            }

            // Jika ada foto baru diupload
            $namaFoto = $foto->getRandomName();
            $uploadPath = FCPATH . 'uploads/sekolah/';

            // Ensure directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $foto->move($uploadPath, $namaFoto);

            // Hapus foto lama jika sedang edit
            if ($this->request->getPost('foto_lama') && file_exists($uploadPath . $this->request->getPost('foto_lama'))) {
                @unlink($uploadPath . $this->request->getPost('foto_lama'));
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
            $uploadPath = FCPATH . 'uploads/sekolah/';
            if ($sekolah['foto'] && file_exists($uploadPath . $sekolah['foto'])) {
                @unlink($uploadPath . $sekolah['foto']);
            }
            $this->sekolahModel->delete($id);
            log_activity('hapus', 'sekolah', $id, 'Menghapus data sekolah: ' . $sekolah['nama_sekolah']);
            return redirect()->to(base_url('admin/sekolah'))->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to(base_url('admin/sekolah'))->with('error', 'Data tidak ditemukan');
    }
}
