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
}
