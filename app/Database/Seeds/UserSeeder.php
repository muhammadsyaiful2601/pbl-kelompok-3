<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'admin',
            'password'     => password_hash('admin123', PASSWORD_BCRYPT),
            'nama_lengkap' => 'Administrator WebGIS'
        ];

        // Menyisipkan data ke dalam tabel user
        $this->db->table('user')->insert($data);
    }
}
