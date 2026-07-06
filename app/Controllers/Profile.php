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
            'foto'         => 'max_size[foto,5120]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
        ];

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
        if ($foto && $foto->getError() != 4) {
            if (!is_dir('uploads/user')) {
                mkdir('uploads/user', 0755, true);
            }

            $newName = $foto->getRandomName();
            $foto->move('uploads/user', $newName);

            if ($this->request->getPost('foto_lama') && file_exists('uploads/user/' . $this->request->getPost('foto_lama'))) {
                @unlink('uploads/user/' . $this->request->getPost('foto_lama'));
            }

            $saveData['foto'] = $newName;
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
