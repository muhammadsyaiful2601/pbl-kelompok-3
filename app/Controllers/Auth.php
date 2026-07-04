<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // Mengalihkan ke halaman admin jika user sudah berstatus login
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'superadmin') {
                return redirect()->to(base_url('superadmin/dashboard'));
            }
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id_user'      => $user['id_user'],
                    'username'     => $user['username'],
                    'nama_lengkap' => $user['nama_lengkap'] ?? $user['username'],
                    'role'         => $user['role'],
                    'foto'         => $user['foto'] ?? null,
                    'logged_in'    => true
                ];
                $session->set($sessionData);

                if ($user['role'] === 'superadmin') {
                    return redirect()->to(base_url('superadmin/dashboard'));
                }
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                $session->setFlashdata('error', 'Password yang Anda masukkan salah.');
                return redirect()->back()->withInput();
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();

        // Mengalihkan langsung ke rute utama publik (Landing Page / Peta Sebaran)
        return redirect()->to(base_url('/'))->with('success', 'Anda telah berhasil keluar dari panel admin.');
    }
}
