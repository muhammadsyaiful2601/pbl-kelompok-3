<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Kelola Admin | WebGIS Sekolah',
            'page_title' => 'Manajemen Akun Admin',
            'admins'     => $this->userModel->where('role', 'admin')->findAll(),
        ];

        return view('superadmin/admin/index', $data);
    }

    public function tambah()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Tambah Admin | WebGIS Sekolah',
            'page_title' => 'Tambah Akun Admin Baru',
        ];

        return view('superadmin/admin/tambah', $data);
    }

    public function simpan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $validation = \Config\Services::validation();
        $rules = [
            'username'     => 'required|is_unique[user.username]|min_length[4]',
            'password'     => 'required|min_length[6]',
            'nama_lengkap' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $this->userModel->save([
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role'         => 'admin',
        ]);
        $insertId = $this->userModel->getInsertID();
        log_activity('tambah', 'user', $insertId, 'Menambahkan akun admin baru: ' . $this->request->getPost('username'));

        return redirect()->to(base_url('superadmin/admin'))->with('success', 'Akun admin berhasil ditambahkan.');
    }

    public function hapus($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $user = $this->userModel->find($id);
        if ($user && $user['role'] === 'admin') {
            $this->userModel->delete($id);
            log_activity('hapus', 'user', $id, 'Menghapus akun admin: ' . $user['username']);
            return redirect()->to(base_url('superadmin/admin'))->with('success', 'Akun admin berhasil dihapus.');
        }

        return redirect()->to(base_url('superadmin/admin'))->with('error', 'Gagal menghapus akun.');
    }
}
