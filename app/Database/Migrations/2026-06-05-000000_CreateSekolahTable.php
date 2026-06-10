<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolahTable extends Migration
{
    public function up()
    {
        $fields = [
            'id_sekolah' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => false,
            ],
            'jenjang' => [
                'type'       => 'ENUM',
                'constraint' => ['SD', 'SMP'],
                'null'       => false,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'tipe_objek' => [
                'type'       => 'ENUM',
                'constraint' => ['marker', 'polygon'],
                'null'       => true,
                'default'    => 'marker',
            ],
            'koordinat_polygon' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id_sekolah', true);
        $this->forge->createTable('sekolah', true);
    }

    public function down()
    {
        $this->forge->dropTable('sekolah', true);
    }
}
