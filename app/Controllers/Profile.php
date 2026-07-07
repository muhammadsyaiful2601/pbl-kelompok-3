<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['admin', 'superadmin'])) {
            return redirect()->to(base_url('login'));
        }

        $user = $this->userModel->find(session()->get('id_user'));
        if (!$user) {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Profil Saya | WebGIS Sekolah',
            'page_title' => 'Profil Saya',
            'user'       => $user,
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        if (!session()->get('logged_in') || !in_array(session()->get('role'), ['admin', 'superadmin'])) {
            return redirect()->to(base_url('login'));
        }

        $user = $this->userModel->find(session()->get('id_user'));
        if (!$user) {
            return redirect()->to(base_url('login'));
        }

        $validation = \Config\Services::validation();
        $usernameChanged = $this->request->getPost('username') !== $user['username'];
        $passwordRequired = $usernameChanged || $this->request->getPost('password');

        $rules = [
            'nama_lengkap' => 'permit_empty|min_length[3]',
        ];

        if (empty($this->request->getPost('foto_base64'))) {
            $rules['foto'] = 'max_size[foto,10240]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]';
        }

        if ($passwordRequired) {
            $rules['password'] = 'required|min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $saveData = [
            'id_user' => $user['id_user'],
        ];

        if ($this->request->getPost('username') !== null) {
            $saveData['username'] = $this->request->getPost('username');
        }

        if ($this->request->getPost('nama_lengkap') !== null) {
            $saveData['nama_lengkap'] = $this->request->getPost('nama_lengkap');
        }

        if ($this->request->getPost('password')) {
            $saveData['password'] = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);
        }

        $foto = $this->request->getFile('foto');
        $fotoBase64 = $this->request->getPost('foto_base64');
        $newName = null;

        if (!empty($fotoBase64)) {
            // Proses upload via Base64 (WAF Bypass)
            if (preg_match('/^data:image\/(\w+);base64,/', $fotoBase64, $type)) {
                $data = substr($fotoBase64, strpos($fotoBase64, ',') + 1);
                $type = strtolower($type[1]);

                if (in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $decodedData = base64_decode($data);
                    if ($decodedData !== false) {
                        $newName = bin2hex(random_bytes(16)) . '.' . ($type === 'jpeg' ? 'jpg' : $type);
                        $uploadPath = FCPATH . 'uploads/user/';

                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0755, true);
                        }

                        if ($this->request->getPost('foto_lama') && file_exists($uploadPath . $this->request->getPost('foto_lama'))) {
                            @unlink($uploadPath . $this->request->getPost('foto_lama'));
                        }

                        file_put_contents($uploadPath . $newName, $decodedData);
                        $saveData['foto'] = $newName;

                        // Perbarui data foto di sesi jika yang diupdate adalah profil login
                        if (session()->get('id_user') == $user['id_user']) {
                            session()->set('foto', $newName);
                        }
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
                return redirect()->back()->withInput()->with('errors', ['foto' => $errorStr]);
            }

            $uploadPath = FCPATH . 'uploads/user/';

            // Ensure directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $newName = $foto->getRandomName();
            $foto->move($uploadPath, $newName);

            if ($this->request->getPost('foto_lama') && file_exists($uploadPath . $this->request->getPost('foto_lama'))) {
                @unlink($uploadPath . $this->request->getPost('foto_lama'));
            }

            $saveData['foto'] = $newName;

            // Perbarui data foto di sesi jika yang diupdate adalah profil login
            if (session()->get('id_user') == $user['id_user']) {
                session()->set('foto', $newName);
            }
        }

        $this->userModel->save($saveData);
        log_activity('ubah', 'user', $user['id_user'], 'Memperbarui profil pengguna');

        session()->set([
            'username'     => $saveData['username'],
            'nama_lengkap' => $saveData['nama_lengkap'],
        ]);

        if (isset($saveData['foto'])) {
            session()->set('foto', $saveData['foto']);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
