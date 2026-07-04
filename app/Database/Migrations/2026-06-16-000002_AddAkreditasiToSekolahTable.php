<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAkreditasiToSekolahTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('sekolah') && !$this->db->fieldExists('akreditasi', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'akreditasi' => [
                    'type'       => 'ENUM',
                    'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                    'null'       => false,
                    'default'    => 'Belum Terakreditasi',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('sekolah') && $this->db->fieldExists('akreditasi', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'akreditasi');
        }
    }
}