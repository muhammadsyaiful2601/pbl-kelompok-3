<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToSekolah extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'jenjang',
            ],
            'jumlah_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'alamat',
            ],
            'deskripsi_sekolah' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'jumlah_siswa',
            ],
        ];
        $this->forge->addColumn('sekolah', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('sekolah', ['foto', 'jumlah_siswa', 'deskripsi_sekolah']);
    }
}
