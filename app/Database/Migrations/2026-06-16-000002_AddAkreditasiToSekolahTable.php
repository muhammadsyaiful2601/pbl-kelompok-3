<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAkreditasiToSekolahTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('akreditasi', 'sekolah')) {
            $fields = [
                'akreditasi' => [
                    'type'       => 'ENUM',
                    'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                    'null'       => false,
                    'default'    => 'Belum Terakreditasi',
                ],
            ];
            $this->forge->addColumn('sekolah', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('akreditasi', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'akreditasi');
        }
    }
}
