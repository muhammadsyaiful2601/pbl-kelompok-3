<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGeojsonTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_geojson' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_geojson' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'file_geojson' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_geojson', true);
        $this->forge->createTable('geojson');
    }

    public function down()
    {
        $this->forge->dropTable('geojson');
    }
}
