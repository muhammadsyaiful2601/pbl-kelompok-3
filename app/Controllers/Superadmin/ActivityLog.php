<?php

namespace App\Controllers\Superadmin;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;

class ActivityLog extends BaseController
{
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        $data = [
            'title'      => 'Log Aktivitas Admin | WebGIS Sekolah',
            'page_title' => 'Log Aktivitas Admin',
            'logs'       => $this->activityLogModel->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('superadmin/logs/index', $data);
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        try {
            $this->activityLogModel->delete($id);
            return redirect()->to(base_url('superadmin/logs'))->with('success', 'Log aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/logs'))->with('error', 'Gagal menghapus log: ' . $e->getMessage());
        }
    }

    public function deleteAll()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'superadmin') {
            return redirect()->to(base_url('login'));
        }

        try {
            $this->activityLogModel->where('1=1')->delete();
            return redirect()->to(base_url('superadmin/logs'))->with('success', 'Semua log aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('superadmin/logs'))->with('error', 'Gagal menghapus semua log: ' . $e->getMessage());
        }
    }
}
