<?php

use App\Models\ActivityLogModel;
use Config\Services;

if (!function_exists('log_activity')) {
    function log_activity(string $action, string $targetTable, ?int $targetId, string $description)
    {
        $session = session();
        if ($session->has('logged_in') && $session->get('logged_in')) {
            $logModel = new ActivityLogModel();
            
            $logModel->save([
                'id_user'      => $session->get('id_user') ?: null,
                'username'     => $session->get('username') ?: null,
                'nama_lengkap' => $session->get('nama_lengkap') ?: null,
                'role'         => $session->get('role') ?: null,
                'action'       => $action,
                'target_table' => $targetTable,
                'target_id'    => $targetId,
                'description'  => $description,
                'ip_address'   => Services::request()->getIPAddress(),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
