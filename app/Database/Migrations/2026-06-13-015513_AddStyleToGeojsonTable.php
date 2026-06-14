<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStyleToGeojsonTable extends Migration
{
    public function up()
    {
        $fields = [
            'warna_geojson' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => '#3b82f6',
                'after'      => 'file_geojson'
            ],
            'opacity_geojson' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'default'    => 0.5,
                'after'      => 'warna_geojson'
            ],
        ];
        $this->forge->addColumn('geojson', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('geojson', ['warna_geojson', 'opacity_geojson']);
    }
}
