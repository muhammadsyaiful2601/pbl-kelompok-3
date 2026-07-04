<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'     => 'tester',
            'password'     => password_hash('pbl123', PASSWORD_BCRYPT),
            'nama_lengkap' => 'Akun Percobaan',
            'role'         => 'admin'
        ];

        // Menyisipkan data ke dalam tabel user
        $this->db->table('user')->insert($data);
    }
}
