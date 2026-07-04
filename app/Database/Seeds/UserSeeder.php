<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->truncate();

        $data = [
            [
                'username'     => 'superadmin',
                'password'     => password_hash('superadmin123', PASSWORD_BCRYPT),
                'nama_lengkap' => 'Super Administrator',
                'role'         => 'superadmin'
            ],
            [
                'username'     => 'admin',
                'password'     => password_hash('admin123', PASSWORD_BCRYPT),
                'nama_lengkap' => 'Administrator WebGIS',
                'role'         => 'admin'
            ],
        ];

        // Menyisipkan data ke dalam tabel user
        $this->db->table('user')->insertBatch($data);
    }
}