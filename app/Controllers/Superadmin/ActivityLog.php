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

        $perPage = 10;
        $page = max(1, (int) ($this->request->getGet('page') ?: 1));
        $offset = ($page - 1) * $perPage;

        $totalLogs = $this->activityLogModel->countAllResults();

        $logs = $this->activityLogModel->orderBy('created_at', 'DESC')
            ->findAll($perPage, $offset);

        $data = [
            'title'      => 'Log Aktivitas Admin | WebGIS Sekolah',
            'page_title' => 'Log Aktivitas Admin',
            'logs'       => $logs,
            'total_logs' => $totalLogs,
            'per_page'   => $perPage,
            'current_page' => $page,
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
