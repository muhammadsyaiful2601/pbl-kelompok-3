<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultAdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        // Check if admin user already exists
        $existingAdmin = $userModel->where('username', 'admin')->first();

        if (!$existingAdmin) {
            $data = [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Administrator',
                'role' => 'admin',
                'foto' => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $userModel->insert($data);
            echo "Default admin user created successfully!\n";
            echo "Username: admin\n";
            echo "Password: admin123\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}